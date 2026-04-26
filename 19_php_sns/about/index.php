<?php
// 共通ファイル app.php を読み込み
require_once '../app.php';

use App\Models\AuthUser;

$auth_user = AuthUser::get();

?>

<!DOCTYPE html>
<html lang="ja">

<?php include COMPONENT_DIR . 'head.php'; ?>

<body class="bg-sky-50 min-h-screen">
    <?php if (isset($auth_user)): ?>
        <?php include COMPONENT_DIR . 'nav.php'; ?>
    <?php else: ?>
        <?php include COMPONENT_DIR . 'public_nav.php'; ?>
    <?php endif; ?>

    <main class="max-w-5xl mx-auto px-6 py-10">

        <!-- ページヘッダー -->
        <div class="mb-10">
            <h2 class="text-2xl font-bold text-sky-600">About</h2>
            <p class="text-sm text-gray-400 mt-1">アプリケーション構成・DB スキーマ・ファイル一覧</p>
        </div>

        <!-- ページ＆アクション -->
        <section class="mb-8">
            <h3 class="text-xs font-semibold text-sky-500 uppercase tracking-widest mb-3">Pages &amp; Actions</h3>
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-sky-100">
                <table class="text-xs w-full">
                    <thead>
                        <tr class="bg-sky-50 text-sky-700 text-left border-b border-sky-100">
                            <th class="px-4 py-3 font-semibold">ページ</th>
                            <th class="px-4 py-3 font-semibold">エンドポイント</th>
                            <th class="px-4 py-3 font-semibold">ファイル</th>
                            <th class="px-4 py-3 font-semibold">メソッド</th>
                            <th class="px-4 py-3 font-semibold">備考</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 divide-y divide-gray-50">
                        <?php
                        $pages = [
                            ['トップページ',       BASE_URL,                         'index.php',            'GET',  'home/ へリダイレクト'],
                            ['About',             BASE_URL . 'about/',              'about/index.php',      'GET',  '公開ページ'],
                            ['新規登録',           BASE_URL . 'register/',           'register/index.php',   'GET',  'register/input.php へリダイレクト'],
                            ['新規登録入力',       BASE_URL . 'register/input.php',  'register/input.php',   'GET',  '入力フォーム表示'],
                            ['新規登録実行',       BASE_URL . 'register/add.php',    'register/add.php',     'POST', 'ユーザー登録'],
                            ['新規登録完了',       BASE_URL . 'register/result.php', 'register/result.php',  'GET',  '登録完了画面'],
                            ['ログイン',           BASE_URL . 'login/',              'login/index.php',      'GET',  'login/input.php へリダイレクト'],
                            ['ログイン入力',       BASE_URL . 'login/input.php',     'login/input.php',      'GET',  '入力フォーム表示'],
                            ['ログイン認証',       BASE_URL . 'login/auth.php',      'login/auth.php',       'POST', '認証してセッション保存'],
                            ['ホーム',             BASE_URL . 'home/',               'home/index.php',       'GET',  '要ログイン'],
                            ['ツイート詳細',       BASE_URL . 'home/detail.php',     'home/detail.php',      'GET',  'id クエリ必須'],
                            ['検索',               BASE_URL . 'home/search.php',     'home/search.php',      'GET',  'keyword クエリで検索'],
                            ['メディア',           BASE_URL . 'home/garally.php',    'home/garally.php',     'GET',  '画像一覧'],
                            ['プロフィール',       BASE_URL . 'user/',               'user/index.php',       'GET',  'id 未指定時は自分のプロフィール'],
                            ['プロフィール編集',   BASE_URL . 'user/edit.php',       'user/edit.php',        'GET',  '要ログイン'],
                            ['プロフィール更新',   BASE_URL . 'user/update.php',     'user/update.php',      'POST', '要ログイン'],
                            ['ログアウト',         BASE_URL . 'user/logout.php',     'user/logout.php',      'GET',  'セッション破棄'],
                        ];
                        foreach ($pages as [$label, $endpoint, $file, $method, $note]):
                            $badge = $method === 'GET'
                                ? 'bg-green-100 text-green-700'
                                : 'bg-blue-100 text-blue-700';
                        ?>
                            <tr class="hover:bg-sky-50/40 transition">
                                <td class="px-4 py-3"><?= $label ?></td>
                                <td class="px-4 py-3 font-mono text-sky-600"><?= $endpoint ?></td>
                                <td class="px-4 py-3 font-mono text-gray-500"><?= $file ?></td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-0.5 rounded <?= $badge ?>"><?= $method ?></span>
                                </td>
                                <td class="px-4 py-3 text-gray-400"><?= $note ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- ファイル構成 -->
        <section class="mb-8">
            <h3 class="text-xs font-semibold text-sky-500 uppercase tracking-widest mb-3">Files</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <!-- 基本ファイル -->
                <div class="bg-white rounded-2xl shadow-sm border border-sky-100 overflow-hidden">
                    <div class="px-4 py-3 bg-sky-50 border-b border-sky-100">
                        <span class="text-xs font-semibold text-sky-700">基本ファイル</span>
                    </div>
                    <ul class="divide-y divide-gray-50 text-xs text-gray-600">
                        <li class="px-4 py-3">
                            <p class="font-mono text-gray-800">app.php</p>
                            <p class="text-gray-400 mt-0.5">パス定数・セッション・モデル読み込み</p>
                        </li>
                        <li class="px-4 py-3">
                            <p class="font-mono text-gray-800">env.php</p>
                            <p class="text-gray-400 mt-0.5">DB 接続設定（ホスト・DB名・認証情報）</p>
                        </li>
                        <li class="px-4 py-3">
                            <p class="font-mono text-gray-800">lib/Database.php</p>
                            <p class="text-gray-400 mt-0.5">PDO シングルトン</p>
                        </li>
                    </ul>
                </div>

                <!-- コンポーネント -->
                <div class="bg-white rounded-2xl shadow-sm border border-sky-100 overflow-hidden">
                    <div class="px-4 py-3 bg-sky-50 border-b border-sky-100">
                        <span class="text-xs font-semibold text-sky-700">コンポーネント</span>
                    </div>
                    <ul class="divide-y divide-gray-50 text-xs text-gray-600">
                        <li class="px-4 py-3">
                            <p class="font-mono text-gray-800">components/head.php</p>
                            <p class="text-gray-400 mt-0.5">HTML &lt;head&gt;（Tailwind CDN など）</p>
                        </li>
                        <li class="px-4 py-3">
                            <p class="font-mono text-gray-800">components/nav.php</p>
                            <p class="text-gray-400 mt-0.5">ナビゲーション（$auth_user で切り替え）</p>
                        </li>
                        <li class="px-4 py-3">
                            <p class="font-mono text-gray-800">components/error_message.php</p>
                            <p class="text-gray-400 mt-0.5">セッションエラー表示</p>
                        </li>
                    </ul>
                </div>

                <!-- モデル -->
                <div class="bg-white rounded-2xl shadow-sm border border-sky-100 overflow-hidden">
                    <div class="px-4 py-3 bg-sky-50 border-b border-sky-100">
                        <span class="text-xs font-semibold text-sky-700">モデル</span>
                    </div>
                    <ul class="divide-y divide-gray-50 text-xs text-gray-600">
                        <li class="px-4 py-3">
                            <p class="font-mono text-gray-800">app/models/User.php</p>
                            <p class="text-gray-400 mt-0.5">PDO による users テーブル操作・認証</p>
                        </li>
                        <li class="px-4 py-3">
                            <p class="font-mono text-gray-800">app/models/AuthUser.php</p>
                            <p class="text-gray-400 mt-0.5">セッション管理（User を継承）</p>
                        </li>
                    </ul>
                </div>

            </div>
        </section>

        <!-- DB スキーマ -->
        <section class="mb-8">
            <h3 class="text-xs font-semibold text-sky-500 uppercase tracking-widest mb-3">DB Schema</h3>
            <p class="text-xs text-gray-400 mb-4 pl-1">定義: <span class="font-mono">docs/schema.sql</span></p>

            <?php
            $tables = [
                [
                    'name'    => 'users',
                    'columns' => [
                        ['id',            'bigint',       'PK / AUTO_INCREMENT',       'ユーザ ID'],
                        ['account_name',  'varchar(255)', 'UNIQUE / NOT NULL',          'アカウント名'],
                        ['email',         'varchar(255)', 'UNIQUE / NOT NULL',          'メールアドレス'],
                        ['display_name',  'varchar(255)', 'NOT NULL',                   '表示名（AS name でエイリアス）'],
                        ['password',      'varchar(255)', 'NOT NULL',                   'パスワードハッシュ'],
                        ['profile',       'text',         'DEFAULT NULL',               'プロフィール文'],
                        ['profile_image', 'text',         'DEFAULT NULL',               'プロフィール画像パス（AS image でエイリアス）'],
                        ['created_at',    'datetime',     'NOT NULL / DEFAULT NOW()',   '作成日時'],
                        ['updated_at',    'datetime',     'NOT NULL / ON UPDATE NOW()', '更新日時'],
                    ],
                ],
            ];
            foreach ($tables as $table):
            ?>
                <div class="mb-6">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="font-mono text-sm font-bold text-gray-700"><?= $table['name'] ?></span>
                        <?php if (isset($table['unique'])): ?>
                            <span class="text-xs px-2 py-0.5 bg-amber-50 text-amber-600 border border-amber-200 rounded">
                                <?= $table['unique'] ?>
                            </span>
                        <?php endif ?>
                    </div>
                    <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-sky-100">
                        <table class="text-xs w-full">
                            <thead>
                                <tr class="bg-sky-50 text-sky-700 text-left border-b border-sky-100">
                                    <th class="px-4 py-2.5 font-semibold">カラム</th>
                                    <th class="px-4 py-2.5 font-semibold">型</th>
                                    <th class="px-4 py-2.5 font-semibold">制約</th>
                                    <th class="px-4 py-2.5 font-semibold">説明</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 divide-y divide-gray-50">
                                <?php foreach ($table['columns'] as [$col, $type, $constraint, $desc]): ?>
                                    <tr class="hover:bg-sky-50/40 transition">
                                        <td class="px-4 py-2.5 font-mono text-sky-700"><?= $col ?></td>
                                        <td class="px-4 py-2.5 font-mono text-gray-500"><?= $type ?></td>
                                        <td class="px-4 py-2.5 text-gray-400"><?= $constraint ?></td>
                                        <td class="px-4 py-2.5 text-gray-500"><?= $desc ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endforeach ?>
        </section>

    </main>

</body>

</html>
