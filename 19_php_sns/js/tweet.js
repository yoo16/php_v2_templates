// インフィニティスクロール用の状態
const TWEET_LIMIT = 10;
let tweetOffset = 0;
let tweetLoading = false;
let tweetHasMore = true;

/**
 * Sanitize（サニタイズ）
 * @param {*} str 
 * @returns 
 */
function escapeHtml(str) {
    return String(str ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}

/**
 * brタグを追加
 * @param {*} str 
 * @returns 
 */
function nl2br(str) {
    return escapeHtml(str).replace(/\n/g, '<br>');
}

/**
 * ハッシュタグリンク
 * @param {*} html 
 * @returns 
 */
function linkHashtag(html) {
    return html.replace(/#\s*([一-龯ぁ-んァ-ンー\w]+)/gu, (match, tag) => {
        const url = `home/search.php?keyword=%23${encodeURIComponent(tag)}`;
        return `<a href="${url}" class="text-sky-500 hover:underline">${match}</a>`;
    });
}

/**
 * 「いいね」をsvgで返す
 * @param {*} filled 
 * @returns 
 */
function heartSvg(filled) {
    return filled
        ? `<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
               <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.218l-.022.012-.007.003-.003.001a.752.752 0 01-.704 0l-.003-.001z"/>
           </svg>`
        : `<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
               <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
           </svg>`;
}

/**
 * 「いいね」「コメント」「リポスト」「削除」ボタンを返す
 * @param {*} tweet 
 * @param {*} authUserId 
 * @returns 
 */
function renderTweetNav(tweet, authUserId) {
    // いいね済みかどうか
    const liked = !!tweet.liked;
    const heartColor = liked ? 'text-rose-500' : 'text-slate-400';

    // 削除ボタン
    const deleteBtn = (authUserId && authUserId === tweet.user_id) ? `
        <form action="home/delete.php" method="post" class="ml-auto">
            <div onclick="deleteTweet(this)" class="inline-flex items-center gap-1.5 text-slate-400 hover:text-red-500 transition cursor-pointer">
                <img src="svg/trash.svg" class="w-4 h-4" alt="削除">
            </div>
            <input type="hidden" name="tweet_id" value="${tweet.id}">
            <input type="hidden" name="user_id" value="${authUserId}">
        </form>` : '';

    // いいね、コメント、リポスト、削除ボタンのレンダリング
    return `
        <div class="flex items-center gap-5 mt-3">
            <button type="button"
                class="reply-btn inline-flex items-center gap-1.5 text-slate-400 hover:text-sky-500 transition"
                data-tweet-id="${tweet.id}">
                <img src="svg/bubble.svg" class="w-4 h-4" alt="コメント">
                <span class="reply-count text-xs">${tweet.reply_count ?? 0}</span>
            </button>
            <button type="button"
                class="like-btn inline-flex items-center gap-1.5 ${heartColor} hover:text-rose-500 transition"
                data-tweet-id="${tweet.id}"
                data-liked="${liked}">
                ${heartSvg(liked)}
                <span class="like-count text-xs">${escapeHtml(String(tweet.like_count))}</span>
            </button>
            <div class="inline-flex items-center gap-1.5 text-slate-400 hover:text-emerald-500 transition cursor-pointer">
                <img src="svg/loop.svg" class="w-4 h-4" alt="リポスト">
                <span class="text-xs">0</span>
            </div>
            ${deleteBtn}
        </div>`;
}

/**
 * ツイートHTML の生成
 * @param {*} tweet 
 * @param {*} authUserId 
 * @returns 
 */
function renderTweet(tweet, authUserId) {
    const imageHtml = tweet.image_path ? `
        <div class="mt-2">
            <img src="${escapeHtml(tweet.image_path)}" class="rounded-xl max-w-sm max-h-80 object-cover border border-slate-100" alt="">
        </div>` : '';

    const message = linkHashtag(nl2br(tweet.message));

    // ツイートHTMLのレンダリング
    return `
        <div class="px-4 py-4 border-b border-slate-100 hover:bg-slate-50 transition">
            <div class="flex gap-3">
                <a href="user/?id=${tweet.user_id}" class="shrink-0">
                    <img src="${escapeHtml(tweet.profile_image_url)}" class="rounded-full w-10 h-10 object-cover">
                </a>
                <div class="flex-1 min-w-0">
                    <div class="flex items-baseline gap-1 flex-wrap">
                        <a href="user/?id=${tweet.user_id}" class="font-bold text-slate-900 hover:underline">
                            ${escapeHtml(tweet.display_name)}
                        </a>
                        <span class="text-slate-400 text-sm">@${escapeHtml(tweet.account_name)}</span>
                        <span class="text-slate-400 text-sm">·</span>
                        <span class="text-slate-400 text-sm">${escapeHtml(tweet.created_at)}</span>
                    </div>
                    <div class="mt-1 text-slate-800 text-sm leading-relaxed tweet-message cursor-pointer" data-id="${tweet.id}">
                        ${message}
                    </div>
                    ${imageHtml}
                    ${renderTweetNav(tweet, authUserId)}
                </div>
            </div>
        </div>
        <div class="reply-form-area hidden px-4 pb-3 border-b border-slate-100" data-tweet-id="${tweet.id}">
            <div class="flex gap-2 mt-2">
                <textarea
                    class="flex-1 border border-slate-200 rounded-lg px-3 py-2 text-sm resize-none focus:outline-none focus:border-sky-400"
                    rows="2"
                    placeholder="返信を入力..."></textarea>
                <button type="button"
                    class="reply-submit-btn px-4 py-2 bg-sky-500 text-white text-sm rounded-full hover:bg-sky-600 transition self-end"
                    data-tweet-id="${tweet.id}">
                    返信
                </button>
            </div>
        </div>`;
}

function renderMediaItem(tweet) {
    return `
        <a href="home/detail.php?id=${tweet.id}" class="block overflow-hidden rounded-xl bg-white border border-slate-100 hover:shadow-md transition">
            <img src="${escapeHtml(tweet.image_path)}" alt="" class="w-full h-48 object-cover hover:scale-105 transition-transform duration-200">
        </a>`;
}

/**
 * ツイートメッセージのクリックイベントを初期化
 * @param {Element} container - ツイートが含まれるコンテナ要素
 */
function initTweetMessages(container) {
    container.querySelectorAll('.tweet-message').forEach(el => {
        el.addEventListener('click', (e) => {
            if (e.target.tagName.toLowerCase() !== 'a') {
                window.location.href = `home/detail.php?id=${el.dataset.id}`;
            }
        });
    });
}

/**
 * いいねボタンのクリックイベントを初期化
 * @param {Element} container - ツイートが含まれるコンテナ要素
 */
function initLikeButtons(container) {
    container.querySelectorAll('.like-btn').forEach(btn => {
        btn.addEventListener('click', async () => {
            const tweetId = Number(btn.dataset.tweetId);
            try {
                // データPOST送信
                const uri = apiUrl('api/like/update.php');
                const res = await fetch(uri, {
                    method: 'POST',
                    credentials: 'include',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ tweet_id: tweetId }),
                });
                // エラー時
                if (!res.ok) throw new Error(`HTTP ${res.status}`);
                // JSONパース
                const { like_count, liked } = await res.json();

                // いいねボタン更新
                btn.dataset.liked = String(liked);
                btn.querySelector('.like-count').textContent = like_count;

                // ハートアイコンと色を更新
                btn.innerHTML = heartSvg(liked)
                    + `<span class="like-count text-xs">${like_count}</span>`;
                if (liked) {
                    btn.classList.remove('text-slate-400');
                    btn.classList.add('text-rose-500');
                } else {
                    btn.classList.remove('text-rose-500');
                    btn.classList.add('text-slate-400');
                }
            } catch (e) {
                console.error('like error:', e);
            }
        });
    });
}

/**
 * 返信フォームのイベントを初期化
 * @param {Element} container - ツイートが含まれるコンテナ要素
 */
function initReplyForms(container) {
    // 返信ボタン → フォームのトグル
    container.querySelectorAll('.reply-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const tweetId = btn.dataset.tweetId;
            const area = container.querySelector(`.reply-form-area[data-tweet-id="${tweetId}"]`);
            if (area) area.classList.toggle('hidden');
        });
    });

    // 返信送信ボタン
    container.querySelectorAll('.reply-submit-btn').forEach(btn => {
        btn.addEventListener('click', async () => {
            const tweetId = Number(btn.dataset.tweetId);
            const area = btn.closest('.reply-form-area');
            const textarea = area.querySelector('textarea');
            const message = textarea.value.trim();
            if (!message) return;

            btn.disabled = true;
            try {
                const res = await fetch(apiUrl('api/reply/add.php'), {
                    method: 'POST',
                    credentials: 'include',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ tweet_id: tweetId, message }),
                });
                if (!res.ok) throw new Error(`HTTP ${res.status}`);
                const reply = await res.json();

                // 入力欄をリセット・閉じる
                textarea.value = '';
                area.classList.add('hidden');

                // 返信数を更新
                const replyBtn = container.querySelector(`.reply-btn[data-tweet-id="${tweetId}"]`);
                if (replyBtn) {
                    const countEl = replyBtn.querySelector('.reply-count');
                    if (countEl) countEl.textContent = reply.reply_count;
                }
            } catch (e) {
                console.error('reply error:', e);
                alert('返信に失敗しました');
            } finally {
                btn.disabled = false;
            }
        });
    });
}

/**
 * 投稿の取得
 * インフィニティスクロールに対応
 * 
 * @param {*} container 
 * @param {*} authUserId 
 * @param {*} spinner 
 * @param {*} sentinel 
 * @param {*} observer 
 * @returns 
 */
async function fetchMoreTweets(container, authUserId, spinner, sentinel, observer) {
    if (tweetLoading || !tweetHasMore) return;
    tweetLoading = true;
    spinner.classList.remove('hidden');

    try {
        // 投稿を取得
        const uri = apiUrl(`api/tweet/get.php?limit=${TWEET_LIMIT}&offset=${tweetOffset}`);
        // Fetch APIで投稿を取得
        const res = await fetch(uri, { credentials: 'include' });
        // レスポンスがOKでない場合はエラーを投げる
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        // JSONをパース
        const tweets = await res.json();

        // 最初のページで投稿がない場合は、投稿がない旨を表示
        if (tweetOffset === 0 && !tweets.length) {
            container.innerHTML = '<p class="p-8 text-center text-slate-400 text-sm">投稿がありません</p>';
            tweetHasMore = false;
            return;
        }

        // 新しいツイートを一時要素でレンダリング・初期化してからDOMに追加
        const temp = document.createElement('div');
        temp.innerHTML = tweets.map(t => renderTweet(t, authUserId)).join('');
        // ツイートメッセージ・いいね・返信フォームを初期化
        initTweetMessages(temp);
        initLikeButtons(temp);
        initReplyForms(temp);
        // DOMに追加
        container.insertBefore(temp, sentinel);

        // Offset を更新
        tweetOffset += tweets.length;

        // 最後のページの場合
        if (tweets.length < TWEET_LIMIT) {
            tweetHasMore = false;
            // 監視を停止
            observer.disconnect();
            // sentinelを削除
            sentinel.remove();
        }
    } catch (e) {
        if (tweetOffset === 0) {
            container.innerHTML = '<p class="p-8 text-center text-red-400 text-sm">読み込みに失敗しました</p>';
        }
        console.error(e);
    } finally {
        tweetLoading = false;
        spinner.classList.add('hidden');
    }
}

/**
 * ツイートを読み込む
 * @returns {void}
 */
async function loadTweets() {
    const container = document.getElementById('tweet-list');
    if (!container) return;

    // ログインユーザーIDを取得
    const authUserId = container.dataset.authUserId ? Number(container.dataset.authUserId) : null;

    // 既存の #tweet-list-loading をスピナーとして使用
    const spinner = document.getElementById('tweet-list-loading');

    // IntersectionObserver の監視対象（sentinel）
    const sentinel = document.createElement('div');
    container.appendChild(sentinel);
    // スピナーをsentinelの後ろに移動（インフィニティスクロール時にリスト末尾に表示するため）
    container.appendChild(spinner);

    // IntersectionObserver で sentinel を監視し、viewport に入るたびに次の10件をロード
    const observer = new IntersectionObserver((entries) => {
        if (entries[0].isIntersecting) {
            fetchMoreTweets(container, authUserId, spinner, sentinel, observer);
        }
    }, { rootMargin: '200px' });

    // 監視開始
    observer.observe(sentinel);
}

/**
 * 検索結果を読み込む
 * @returns {void}
 */
async function loadSearchResults() {
    const container = document.getElementById('search-result');
    if (!container) return;

    // キーワード
    const keyword = new URLSearchParams(location.search).get('keyword') ?? '';
    const authUserId = container.dataset.authUserId ? Number(container.dataset.authUserId) : null;

    if (!keyword) {
        container.innerHTML = '<p class="p-8 text-center text-slate-400 text-sm">キーワードを入力してください</p>';
        return;
    }

    // 検索中の表示
    container.innerHTML = '<p class="p-8 text-center text-slate-400 text-sm">検索中...</p>';

    try {
        // 検索結果を取得
        const uri = apiUrl(`api/tweet/search.php?keyword=${encodeURIComponent(keyword)}`);
        // Fetch APIで検索結果を取得
        const res = await fetch(uri, { credentials: 'include' });
        // エラーハンドリング
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        // JSONをパース
        const tweets = await res.json();
        // ヘッダー
        const header = `
            <div class="px-4 py-3 border-b border-slate-100">
                <p class="text-sm text-slate-500">「<span class="font-bold text-slate-800">${escapeHtml(keyword)}</span>」の検索結果</p>
                <p class="text-xs text-slate-400 mt-0.5">${tweets.length} 件</p>
            </div>`;
        // 検索結果がない場合
        if (!tweets.length) {
            container.innerHTML = header + '<p class="p-8 text-center text-slate-400 text-sm">投稿が見つかりませんでした</p>';
            return;
        }
        // 検索結果を表示
        container.innerHTML = header + tweets.map(t => renderTweet(t, authUserId)).join('');
        // ツイートメッセージ・いいね・返信フォームを初期化
        initTweetMessages(container);
        initLikeButtons(container);
        initReplyForms(container);
    } catch (e) {
        container.innerHTML = '<p class="p-8 text-center text-red-400 text-sm">読み込みに失敗しました</p>';
        console.error(e);
    }
}

/**
 * ツイート投稿フォームの初期化
 */
function initTweetForm() {
    const form = document.getElementById('tweet-form');
    if (!form) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const textarea = form.querySelector('textarea[name="message"]');
        const submitBtn = form.querySelector('button[type="submit"]');

        submitBtn.disabled = true;

        const body = new FormData(form);
        try {
            const uri = apiUrl('api/tweet/add.php');
            const res = await fetch(uri, {
                method: 'POST',
                credentials: 'include',
                body: body,
            });

            // 認証エラー
            if (res.status === 401) {
                window.location.href = 'login/';
                return;
            }
            // その他のエラー
            if (!res.ok) {
                let payload = null;
                try {
                    payload = await res.json();
                } catch (_) {
                    const text = await res.text();
                    console.error('tweet add non-json error:', text);
                }
                console.error('tweet add failed:', payload);
                alert(payload?.error ?? '投稿に失敗しました');
                return;
            }

            // JSONをパース
            const tweet = await res.json();

            // フォームをリセット
            textarea.value = '';
            document.getElementById('imagePreviewContainer').innerHTML = '';

            // ファイル入力をリセット
            const fileInput = document.getElementById('fileInput');
            if (fileInput) fileInput.value = '';

            // ツイートをリストの先頭に追加
            const container = document.getElementById('tweet-list');
            if (container) {
                const authUserId = container.dataset.authUserId ? Number(container.dataset.authUserId) : null;

                // 新しいツイートを一時要素でレンダリング・初期化してからDOMに追加
                const temp = document.createElement('div');
                temp.innerHTML = renderTweet(tweet, authUserId);
                initTweetMessages(temp);
                initLikeButtons(temp);
                initReplyForms(temp);
                // DOMに追加
                container.insertBefore(temp.firstElementChild, container.firstChild);
            }
        } catch (e) {
            console.error('post error:', e);
            alert('投稿に失敗しました');
        } finally {
            submitBtn.disabled = false;
        }
    });
}

/**
 * ユーザーのツイートを読み込む
 */
async function loadUserTweets() {
    const container = document.getElementById('user-tweet-list');
    if (!container) return;

    const userId     = container.dataset.userId     ? Number(container.dataset.userId)     : null;
    const authUserId = container.dataset.authUserId ? Number(container.dataset.authUserId) : null;
    const loading    = document.getElementById('user-tweet-list-loading');

    try {
        const res = await fetch(apiUrl(`api/tweet/user.php?user_id=${userId}`), { credentials: 'include' });
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        const tweets = await res.json();

        if (!tweets.length) {
            loading.outerHTML = '<p class="p-8 text-center text-slate-400 text-sm">投稿がありません</p>';
            return;
        }

        const temp = document.createElement('div');
        temp.innerHTML = tweets.map(t => renderTweet(t, authUserId)).join('');
        initTweetMessages(temp);
        initLikeButtons(temp);
        initReplyForms(temp);
        loading.replaceWith(...temp.childNodes);
    } catch (e) {
        if (loading) loading.outerHTML = '<p class="p-8 text-center text-red-400 text-sm">読み込みに失敗しました</p>';
        console.error(e);
    }
}

async function loadMediaGallery() {
    const container = document.getElementById('media-gallery');
    if (!container) return;

    const loading = document.getElementById('media-gallery-loading');

    try {
        const res = await fetch(apiUrl('api/tweet/garally.php'), { credentials: 'include' });

        if (res.status === 401) {
            window.location.href = 'login/';
            return;
        }
        if (!res.ok) throw new Error(`HTTP ${res.status}`);

        const tweets = await res.json();

        if (!tweets.length) {
            loading.outerHTML = '<p class="p-8 text-center text-slate-400 text-sm">画像付きの投稿はまだありません。</p>';
            return;
        }

        const grid = document.createElement('div');
        grid.className = 'grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3';
        grid.innerHTML = tweets.map(renderMediaItem).join('');
        loading.replaceWith(grid);
    } catch (e) {
        if (loading) {
            loading.outerHTML = '<p class="p-8 text-center text-red-400 text-sm">読み込みに失敗しました</p>';
        }
        console.error(e);
    }
}

/**
 * 初期ロード
 */
document.addEventListener('DOMContentLoaded', () => {
    initTweetForm();
    loadTweets();
    loadSearchResults();
    loadUserTweets();
    loadMediaGallery();
});
