<div class="flex max-w-4xl mx-auto min-h-screen">

    <!-- サイドナビ -->
    <header class="w-56 shrink-0 sticky top-0 self-start h-screen border-r border-slate-100">
        <?php include COMPONENT_DIR . 'nav.php' ?>
    </header>

    <!-- メインコンテンツ -->
    <main class="flex-1 border-r border-slate-100 min-h-screen">
        <div class="p-5 border-b border-slate-100">
            <a href="<?= BASE_URL ?>home/" class="font-bold">&larr; <span class="ml-4">ポスト</span></a>
        </div>

        <div id="tweet-detail" data-tweet-id="<?= $tweet_id ?>" data-auth-user-id="<?= $auth_user['id'] ?>">
            <div id="tweet-detail-loading" class="p-8 flex justify-center text-slate-400">
                <svg class="animate-spin w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
            </div>
        </div>

        <!-- 返信一覧 -->
        <div id="reply-list" data-tweet-id="<?= $tweet_id ?>" class="mx-4 border-t border-slate-100">
            <div id="reply-list-loading" class="p-6 flex justify-center text-slate-400">
                <svg class="animate-spin w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
            </div>
        </div>
    </main>

</div>

<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const container = document.getElementById('tweet-detail');
        if (!container) return;

        const loading = document.getElementById('tweet-detail-loading');
        const tweetId = Number(container.dataset.tweetId);
        const authUserId = container.dataset.authUserId ? Number(container.dataset.authUserId) : null;

        try {
            const res = await fetch('<?= BASE_URL ?>api/tweet/fetch.php?id=' + tweetId, {
                credentials: 'include'
            });
            if (!res.ok) throw new Error(`HTTP ${res.status}`);
            const tweet = await res.json();

            const temp = document.createElement('div');
            temp.innerHTML = renderTweet(tweet, authUserId);
            initTweetMessages(temp);
            initLikeButtons(temp);
            initReplyForms(temp);

            loading.replaceWith(temp.firstElementChild);
        } catch (e) {
            loading.outerHTML = '<p class="p-8 text-center text-red-400 text-sm">読み込みに失敗しました</p>';
            console.error(e);
        }

        // 返信一覧を取得・表示（reply.js の loadReplies を使用）
        loadReplies();
    });
</script>
