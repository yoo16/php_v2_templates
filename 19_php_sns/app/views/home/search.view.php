<div class="flex max-w-4xl mx-auto min-h-screen">

    <!-- サイドナビ -->
    <header class="w-56 shrink-0 sticky top-0 self-start h-screen border-r border-slate-100">
        <?php include COMPONENT_DIR . 'nav.php' ?>
    </header>

    <!-- メインコンテンツ -->
    <main class="flex-1 border-r border-slate-100 min-h-screen">
        <?php include COMPONENT_DIR . 'search_form.php' ?>

        <?php include COMPONENT_DIR . 'tweet_form.php' ?>

        <!-- 検索結果（CSR） -->
        <div id="search-result" data-auth-user-id="<?= $auth_user['id'] ?>"></div>
    </main>

</div>
