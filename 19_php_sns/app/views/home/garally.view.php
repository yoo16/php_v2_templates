<div class="flex max-w-4xl mx-auto min-h-screen">

    <!-- サイドナビ -->
    <header class="w-56 shrink-0 sticky top-0 self-start h-screen border-r border-slate-100">
        <?php include COMPONENT_DIR . 'nav.php' ?>
    </header>

    <!-- メインコンテンツ -->
    <main class="flex-1 border-r border-slate-100 min-h-screen">
        <div class="px-6 py-5 border-b border-slate-100">
            <h1 class="text-2xl font-bold text-slate-900">メディア</h1>
            <p class="text-sm text-slate-500 mt-1">画像付きの投稿を新しい順に表示します。</p>
        </div>

        <div id="media-gallery" class="p-4">
            <div id="media-gallery-loading" class="p-8 flex justify-center text-slate-400">
                <svg class="animate-spin w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
            </div>
        </div>
    </main>

</div>
