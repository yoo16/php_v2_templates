<?php
// 共通ファイル app.php を読み込み
require_once '../app.php';
?>

<!DOCTYPE html>
<html lang="ja">

<?php include COMPONENT_DIR . 'head.php'; ?>

<body class="bg-white text-slate-900 antialiased min-h-screen">
    <?php include COMPONENT_DIR . 'public_nav.php'; ?>

    <main class="max-w-4xl mx-auto px-6 py-10">

        <!-- ページヘッダー -->
        <div class="mb-10">
            <h2 class="text-2xl font-bold text-slate-900">About</h2>
            <p class="mt-1 text-sm text-slate-500">アプリケーション構成・DB スキーマ・ファイル一覧</p>
        </div>

        <!-- ページ＆アクション -->
        <section class="mb-8">
            <h3 class="mb-3 text-xs font-semibold uppercase tracking-widest text-slate-500">Pages &amp; Actions</h3>
            <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white">
                <table class="text-xs w-full">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50 text-left text-slate-600">
                            <th class="px-4 py-3 font-semibold">ページ</th>
                            <th class="px-4 py-3 font-semibold">エンドポイント</th>
                            <th class="px-4 py-3 font-semibold">ファイル</th>
                            <th class="px-4 py-3 font-semibold">メソッド</th>
                            <th class="px-4 py-3 font-semibold">備考</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-600">
                        <?php
                        $pages = [
                            ['トップページ',       '/',                         'index.php',            'GET',  'home/ へリダイレクト'],
                            ['About',             'about/',              'about/index.php',      'GET',  '公開ページ'],
                            ['新規登録',           'register/',           'register/index.php',   'GET',  'register/input.php へリダイレクト'],
                            ['新規登録入力',       'register/input.php',  'register/input.php',   'GET',  '入力フォーム表示'],
                            ['新規登録実行',       'register/add.php',    'register/add.php',     'POST', 'ユーザー登録'],
                            ['新規登録完了',       'register/result.php', 'register/result.php',  'GET',  '登録完了画面'],
                            ['ログイン',           'login/',              'login/index.php',      'GET',  'login/input.php へリダイレクト'],
                            ['ログイン入力',       'login/input.php',     'login/input.php',      'GET',  '入力フォーム表示'],
                            ['ログイン認証',       'login/auth.php',      'login/auth.php',       'POST', '認証してセッション保存'],
                            ['ホーム',             'home/',               'home/index.php',       'GET',  '要ログイン'],
                            ['ツイート詳細',       'home/detail.php',     'home/detail.php',      'GET',  'id クエリ必須'],
                            ['検索',               'home/search.php',     'home/search.php',      'GET',  'keyword クエリで検索'],
                            ['メディア',           'home/garally.php',    'home/garally.php',     'GET',  '画像一覧'],
                            ['プロフィール',       'user/',               'user/index.php',       'GET',  'id 未指定時は自分のプロフィール'],
                            ['プロフィール編集',   'user/edit.php',       'user/edit.php',        'GET',  '要ログイン'],
                            ['プロフィール更新',   'user/update.php',     'user/update.php',      'POST', '要ログイン'],
                            ['ログアウト',         'user/logout.php',     'user/logout.php',      'GET',  'セッション破棄'],
                        ];
                        foreach ($pages as [$label, $endpoint, $file, $method, $note]):
                            $badge = $method === 'GET'
                                ? 'bg-green-100 text-green-700'
                                : 'bg-blue-100 text-blue-700';
                        ?>
                            <tr class="transition hover:bg-slate-50">
                                <td class="px-4 py-3"><?= $label ?></td>
                                <td class="px-4 py-3 font-mono text-sky-600"><?= $endpoint ?></td>
                                <td class="px-4 py-3 font-mono text-slate-500"><?= $file ?></td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-0.5 rounded <?= $badge ?>"><?= $method ?></span>
                                </td>
                                <td class="px-4 py-3 text-slate-400"><?= $note ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- ファイル構成 -->
        <section class="mb-8">
            <h3 class="mb-3 text-xs font-semibold uppercase tracking-widest text-slate-500">Files</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <!-- 基本ファイル -->
                <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white">
                    <div class="border-b border-slate-100 bg-slate-50 px-4 py-3">
                        <span class="text-xs font-semibold text-slate-700">基本ファイル</span>
                    </div>
                    <ul class="divide-y divide-slate-100 text-xs text-slate-600">
                        <li class="px-4 py-3">
                            <p class="font-mono text-slate-800">app.php</p>
                            <p class="mt-0.5 text-slate-400">パス定数・セッション・モデル読み込み</p>
                        </li>
                        <li class="px-4 py-3">
                            <p class="font-mono text-slate-800">env.php</p>
                            <p class="mt-0.5 text-slate-400">DB 接続設定（ホスト・DB名・認証情報）</p>
                        </li>
                        <li class="px-4 py-3">
                            <p class="font-mono text-slate-800">lib/Database.php</p>
                            <p class="mt-0.5 text-slate-400">PDO シングルトン</p>
                        </li>
                    </ul>
                </div>

                <!-- コンポーネント -->
                <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white">
                    <div class="border-b border-slate-100 bg-slate-50 px-4 py-3">
                        <span class="text-xs font-semibold text-slate-700">コンポーネント</span>
                    </div>
                    <ul class="divide-y divide-slate-100 text-xs text-slate-600">
                        <li class="px-4 py-3">
                            <p class="font-mono text-slate-800">components/head.php</p>
                            <p class="mt-0.5 text-slate-400">HTML &lt;head&gt;（Tailwind CDN など）</p>
                        </li>
                        <li class="px-4 py-3">
                            <p class="font-mono text-slate-800">components/nav.php</p>
                            <p class="mt-0.5 text-slate-400">ナビゲーション（$auth_user で切り替え）</p>
                        </li>
                        <li class="px-4 py-3">
                            <p class="font-mono text-slate-800">components/error_message.php</p>
                            <p class="mt-0.5 text-slate-400">セッションエラー表示</p>
                        </li>
                    </ul>
                </div>

                <!-- モデル -->
                <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white">
                    <div class="border-b border-slate-100 bg-slate-50 px-4 py-3">
                        <span class="text-xs font-semibold text-slate-700">モデル</span>
                    </div>
                    <ul class="divide-y divide-slate-100 text-xs text-slate-600">
                        <li class="px-4 py-3">
                            <p class="font-mono text-slate-800">app/models/User.php</p>
                            <p class="mt-0.5 text-slate-400">PDO による users テーブル操作・認証</p>
                        </li>
                        <li class="px-4 py-3">
                            <p class="font-mono text-slate-800">app/models/AuthUser.php</p>
                            <p class="mt-0.5 text-slate-400">セッション管理（User を継承）</p>
                        </li>
                    </ul>
                </div>

            </div>
        </section>

        <!-- DB スキーマ -->
        <section class="mb-8">
            <h3 class="mb-3 text-xs font-semibold uppercase tracking-widest text-slate-500">DB Schema</h3>
            <p class="mb-4 pl-1 text-xs text-slate-400">定義: <span class="font-mono">docs/schema.sql</span></p>

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
                        <span class="font-mono text-sm font-bold text-slate-700"><?= $table['name'] ?></span>
                        <?php if (isset($table['unique'])): ?>
                            <span class="rounded border border-amber-200 bg-amber-50 px-2 py-0.5 text-xs text-amber-600">
                                <?= $table['unique'] ?>
                            </span>
                        <?php endif ?>
                    </div>
                    <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white">
                        <table class="text-xs w-full">
                            <thead>
                                <tr class="border-b border-slate-100 bg-slate-50 text-left text-slate-600">
                                    <th class="px-4 py-2.5 font-semibold">カラム</th>
                                    <th class="px-4 py-2.5 font-semibold">型</th>
                                    <th class="px-4 py-2.5 font-semibold">制約</th>
                                    <th class="px-4 py-2.5 font-semibold">説明</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-slate-600">
                                <?php foreach ($table['columns'] as [$col, $type, $constraint, $desc]): ?>
                                    <tr class="transition hover:bg-slate-50">
                                        <td class="px-4 py-2.5 font-mono text-sky-700"><?= $col ?></td>
                                        <td class="px-4 py-2.5 font-mono text-slate-500"><?= $type ?></td>
                                        <td class="px-4 py-2.5 text-slate-400"><?= $constraint ?></td>
                                        <td class="px-4 py-2.5 text-slate-500"><?= $desc ?></td>
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
