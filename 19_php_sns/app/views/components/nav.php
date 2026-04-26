<?php

use App\Models\AuthUser;

$auth_user = AuthUser::get();
?>

<?php if (isset($auth_user)): ?>
    <nav id="side-menu" class="flex flex-col gap-1 p-4 h-full">

        <a href="<?= BASE_URL ?>home/" class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-sky-50 text-slate-800 font-semibold transition">
            <img src="<?= BASE_URL ?>svg/home.svg" class="w-6 h-6 shrink-0">
            <span>ホーム</span>
        </a>

        <a href="<?= BASE_URL ?>home/garally.php" class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-sky-50 text-slate-800 font-semibold transition">
            <img src="<?= BASE_URL ?>svg/camera.svg" class="w-6 h-6 shrink-0">
            <span>メディア</span>
        </a>

        <!-- ユーザーメニュー（下部） -->
        <div class="mt-auto pt-4 border-t border-slate-100 relative">
            <button id="user-menu" class="flex items-center gap-3 w-full px-3 py-2 rounded-xl hover:bg-sky-50 transition text-left">
                <img src="<?= AuthUser::profileImage($auth_user['profile_image']) ?>"
                    class="w-10 h-10 rounded-full object-cover shrink-0" id="user-icon">
                <div class="min-w-0">
                    <p class="text-sm font-bold text-slate-800 truncate"><?= htmlspecialchars($auth_user['display_name']) ?></p>
                    <p class="text-xs text-slate-400 truncate">@<?= htmlspecialchars($auth_user['account_name']) ?></p>
                </div>
            </button>

            <!-- ポップアップ（初期状態は非表示） -->
            <div id="user-popup" class="hidden absolute bottom-full left-0 mb-1 w-56 bg-white border border-slate-200 rounded-xl shadow-lg z-10 overflow-hidden">
                <a href="<?= BASE_URL ?>user/" class="block px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-sky-50 transition">
                    プロフィール
                </a>
                <a href="<?= BASE_URL ?>user/logout.php" class="block px-4 py-3 text-sm font-semibold text-red-500 hover:bg-red-50 transition border-t border-slate-100">
                    @<?= htmlspecialchars($auth_user['account_name']) ?> からログアウト
                </a>
            </div>
        </div>

    </nav>
<?php endif; ?>
