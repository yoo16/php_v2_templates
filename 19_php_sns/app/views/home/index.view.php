<div class="flex max-w-4xl mx-auto min-h-screen">

    <!-- サイドナビ -->
    <header class="w-56 shrink-0 sticky top-0 self-start h-screen border-r border-slate-100">
        <?php include COMPONENT_DIR . 'nav.php' ?>
    </header>

    <!-- メインコンテンツ -->
    <main class="flex-1 border-r border-slate-100 min-h-screen">
        <!-- 検索バー（sticky） -->
        <?php include COMPONENT_DIR . 'search_form.php' ?>

        <!-- ツイート投稿フォーム -->
        <?php include COMPONENT_DIR . 'tweet_form.php' ?>

        <!-- ツイート一覧（CSR） -->
        <div id="tweet-list" data-auth-user-id="<?= $auth_user['id'] ?>">
            <div id="tweet-list-loading" class="p-8 flex justify-center text-slate-400">
                <svg class="animate-spin w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
            </div>
        </div>
    </main>

</div>