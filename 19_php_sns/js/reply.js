// 返信セクションの表示/非表示トグル
function toggleReply(tweetId) {
    const section = document.getElementById(`reply-section-${tweetId}`);
    section.classList.toggle('hidden');

    // 初回表示時のみ返信を取得
    const list = document.getElementById(`reply-list-${tweetId}`);
    if (!section.classList.contains('hidden') && list.dataset.loaded !== 'true') {
        loadReplies(tweetId);
    }
}

// 返信一覧を取得して表示（detail画面専用）
async function loadReplies() {
    const container = document.getElementById('tweet-detail');
    if (!container) return;  // detail画面以外では何もしない

    const tweetId = container.dataset.tweetId;
    const listEl  = document.getElementById('reply-list');
    const loading = document.getElementById('reply-list-loading');
    if (!listEl || !loading) return;

    try {
        const res = await fetch(apiUrl(`api/reply/get.php?tweet_id=${tweetId}`), {
            credentials: 'include',
        });
        if (!res.ok) throw new Error(`HTTP ${res.status}`);

        const replies = await res.json();
        if (!replies.length) {
            loading.outerHTML = '<p class="p-6 text-center text-slate-400 text-sm">返信がありません</p>';
            return;
        }
        loading.outerHTML = replies.map(r => createReplyHtml(r)).join('');
    } catch (e) {
        loading.outerHTML = '<p class="p-6 text-center text-red-400 text-sm">読み込みに失敗しました</p>';
        console.error('Reply load error:', e);
    }
}

// 返信を投稿
async function submitReply(tweetId) {
    const input = document.getElementById(`reply-input-${tweetId}`);
    const message = input.value.trim();
    if (!message) return;

    try {
        const res = await fetch(apiUrl('api/reply/add.php'), {
            method: 'POST',
            credentials: 'include',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ tweet_id: tweetId, message }),
        });
        if (!res.ok) return;

        const reply = await res.json();
        const list = document.getElementById(`reply-list-${tweetId}`);
        list.dataset.loaded = 'true';
        list.insertAdjacentHTML('beforeend', createReplyHtml(reply));
        input.value = '';

        const countEl = document.querySelector(`.reply-count[data-tweet-id="${tweetId}"]`);
        if (countEl) updateReplyCount(tweetId, parseInt(countEl.textContent || '0') + 1);
    } catch (e) {
        console.error('Reply submit error:', e);
    }
}

// 返信数の表示を更新
function updateReplyCount(tweetId, count) {
    const countEl = document.querySelector(`.reply-count[data-tweet-id="${tweetId}"]`);
    if (countEl) countEl.textContent = count;
}

// 返信1件分のHTMLを生成
function createReplyHtml(reply) {
    const profileImg = reply.profile_image_url
        ? escapeHtml(reply.profile_image_url)
        : 'images/profile/default.png';

    return `
        <div class="flex gap-2 py-2 border-b border-slate-50 last:border-0">
            <img src="${profileImg}" class="w-8 h-8 rounded-full object-cover shrink-0 mt-0.5">
            <div class="flex-1 min-w-0">
                <div class="flex items-baseline gap-1 flex-wrap">
                    <span class="font-bold text-sm text-slate-900">${escapeHtml(reply.display_name)}</span>
                    <span class="text-slate-400 text-xs">@${escapeHtml(reply.account_name)}</span>
                    <span class="text-slate-400 text-xs">· ${escapeHtml(reply.created_at)}</span>
                </div>
                <p class="text-sm text-slate-800 mt-0.5 whitespace-pre-wrap">${escapeHtml(reply.message)}</p>
            </div>
        </div>`;
}

// XSS 対策：文字列をHTMLエスケープ
function escapeHtml(str) {
    const div = document.createElement('div');
    div.textContent = String(str ?? '');
    return div.innerHTML;
}
