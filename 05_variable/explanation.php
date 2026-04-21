<?php
$title = '変数とデータ型の基本';
$description = '情報を一時的に保存する「変数」、データの種類を表す「型」、そしてPHPが最初から用意している「スーパーグローバル変数」を学びましょう。';
$lesson_number = 2;
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>解説：変数とデータ型 | PHP Variables & Data Types</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Prism.js for code highlighting -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-okaidia.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="bg-slate-50 text-slate-800 leading-relaxed antialiased">

    <?php include('../components/nav.php'); ?>

    <main class="max-w-4xl mx-auto px-6 py-12">
        <?php include '../components/header.php'; ?>

        <!-- Section 1: Variables -->
        <section class="mb-16">
            <h3 class="text-2xl font-bold text-slate-900 mb-6 flex items-center">
                <span class="w-8 h-8 bg-amber-500 text-white rounded-lg flex items-center justify-center mr-3 text-sm">1</span>
                変数の宣言と代入
            </h3>
            <p class="mb-4">PHPでは <code>$</code> 記号を変数名の先頭につけます。<code>=</code> は「等しい」ではなく「右の値を左の変数に入れる（代入する）」という命令です。</p>
            <pre class="language-php mb-6"><code class="language-php">&lt;?php
// 変数の代入（= は「代入演算子」）
$name   = "ユーザーA";   // string（文字列）
$level  = 5;             // int（整数）
$active = true;          // bool（論理型）

// 変数の中身を画面に出力する
echo $name;   // → ユーザーA

// 短縮形（HTMLの中でよく使う）
// &lt;?= $name ?&gt; は &lt;?php echo $name; ?&gt; と同じ</code></pre>
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 text-sm text-blue-800 rounded-r-2xl">
                <strong>命名ルール：</strong>
                変数名は <code>$</code> の直後から始まり、数字からは始められません。大文字・小文字は区別されます（<code>$Name</code> と <code>$name</code> は別物）。
            </div>
        </section>

        <!-- Section 2: Data Types -->
        <section class="mb-16">
            <h3 class="text-2xl font-bold text-slate-900 mb-6 flex items-center">
                <span class="w-8 h-8 bg-amber-500 text-white rounded-lg flex items-center justify-center mr-3 text-sm">2</span>
                データ型（Data Types）
            </h3>
            <p class="mb-6">変数に入れるデータの「種類」のことをデータ型と呼びます。PHPには次の基本型があります。</p>

            <div class="overflow-x-auto rounded-2xl border border-slate-200 shadow-sm mb-8">
                <table class="w-full text-sm">
                    <thead class="bg-slate-100 text-slate-700 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="px-6 py-3 text-left">型名</th>
                            <th class="px-6 py-3 text-left">種類</th>
                            <th class="px-6 py-3 text-left">値の例</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        <tr>
                            <td class="px-6 py-3 font-mono font-bold text-amber-600">string</td>
                            <td class="px-6 py-3">文字列</td>
                            <td class="px-6 py-3 font-mono text-slate-500">"ユーザーA", 'PHP'</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3 font-mono font-bold text-blue-600">int</td>
                            <td class="px-6 py-3">整数</td>
                            <td class="px-6 py-3 font-mono text-slate-500">5, -10, 0</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3 font-mono font-bold text-purple-600">float</td>
                            <td class="px-6 py-3">浮動小数点数</td>
                            <td class="px-6 py-3 font-mono text-slate-500">1.5, 3.14</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3 font-mono font-bold text-rose-600">bool</td>
                            <td class="px-6 py-3">論理型（真偽値）</td>
                            <td class="px-6 py-3 font-mono text-slate-500">true, false</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3 font-mono font-bold text-slate-400">null</td>
                            <td class="px-6 py-3">値なし</td>
                            <td class="px-6 py-3 font-mono text-slate-500">null</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3 font-mono font-bold text-emerald-600">array</td>
                            <td class="px-6 py-3">配列・連想配列</td>
                            <td class="px-6 py-3 font-mono text-slate-500">["剣", "盾"], ["hp" => 100]</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <pre class="language-php mb-6"><code class="language-php">&lt;?php
// 基本型
$name      = "ユーザーA";          // string
$level     = 5;                    // int
$exp_rate  = 1.5;                  // float
$is_active = true;                 // bool
$last_login = null;                // null

// 配列（インデックス配列）
$items = ["剣", "盾", "回復薬"];
echo $items[0]; // → 剣

// 連想配列（キーと値のペア）
$status = [
    "hp"  => 100,
    "mp"  => 50,
    "job" => "戦士",
];
echo $status["job"]; // → 戦士</code></pre>
        </section>

        <!-- Section 3: var_dump -->
        <section class="mb-16">
            <h3 class="text-2xl font-bold text-slate-900 mb-6 flex items-center">
                <span class="w-8 h-8 bg-amber-500 text-white rounded-lg flex items-center justify-center mr-3 text-sm">3</span>
                <code>var_dump()</code> でデバッグ
            </h3>
            <p class="mb-4"><code>var_dump()</code> は変数の <strong>型</strong> と <strong>値</strong> を同時に表示してくれるデバッグの定番関数です。「なんかおかしい」と思ったらまずこれで確認しましょう。</p>
            <pre class="language-php mb-6"><code class="language-php">&lt;?php
$v1 = "100";   // string
$v2 = 100;     // int
$v3 = 100.0;   // float

var_dump($v1); // → string(3) "100"
var_dump($v2); // → int(100)
var_dump($v3); // → float(100)</code></pre>
            <div class="bg-amber-50 border-l-4 border-amber-400 p-4 text-sm text-amber-800 rounded-r-2xl">
                <strong>使い分け：</strong> 値を確認したいだけなら <code>echo</code>、型まで含めて調べたいなら <code>var_dump()</code> が便利です。
            </div>
        </section>

        <!-- Section 4: Type Comparison -->
        <section class="mb-16">
            <h3 class="text-2xl font-bold text-slate-900 mb-6 flex items-center">
                <span class="w-8 h-8 bg-amber-500 text-white rounded-lg flex items-center justify-center mr-3 text-sm">4</span>
                型の比較と型ジャグリング
            </h3>
            <p class="mb-4">PHPの比較演算子には <strong>値だけ</strong> を比べる <code>==</code> と、<strong>型まで含めて</strong> 比べる <code>===</code> の2種類があります。この違いはバグの原因になりやすいので注意が必要です。</p>
            <pre class="language-php mb-6"><code class="language-php">&lt;?php
$v1 = "100";  // string
$v2 = 100;    // int

var_dump($v1 == $v2);  // → bool(true)  ← 値だけ比べると同じ
var_dump($v1 === $v2); // → bool(false) ← 型が違うので不一致</code></pre>

            <p class="mb-4">また、PHPは計算などで型が異なる場合に自動で変換する <strong>型ジャグリング（Type Juggling）</strong> という仕組みを持っています。</p>
            <pre class="language-php mb-6"><code class="language-php">&lt;?php
$v1 = "100"; // string

// string と int を足すと、string が自動的に int として扱われる
var_dump($v1 + 50); // → int(150)</code></pre>

            <div class="bg-red-50 border-l-4 border-red-400 p-4 text-sm text-red-800 rounded-r-2xl">
                <strong>注意：</strong> 意図しない型変換はバグの元になります。型が重要な比較では、常に <code>===</code>（厳密な比較）を使う習慣をつけましょう。
            </div>
        </section>

        <!-- Section 5: Superglobals -->
        <section class="mb-16">
            <h3 class="text-2xl font-bold text-slate-900 mb-6 flex items-center">
                <span class="w-8 h-8 bg-amber-500 text-white rounded-lg flex items-center justify-center mr-3 text-sm">5</span>
                特別な変数「スーパーグローバル」
            </h3>
            <p class="mb-6">PHPがあらかじめ用意している特別な変数で、どこからでもアクセスできます。どれも <strong>連想配列</strong> として値を保持しています。</p>

            <div class="space-y-4 mb-8">
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                    <h4 class="font-bold text-blue-600 mb-1"><code>$_GET</code></h4>
                    <p class="text-sm text-slate-600">URLの末尾に付いたパラメータ（<code>?name=Taro</code> など）を取得します。</p>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                    <h4 class="font-bold text-rose-600 mb-1"><code>$_POST</code></h4>
                    <p class="text-sm text-slate-600">フォームから <code>method="post"</code> で送信されたデータを取得します。URLには表示されません。</p>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                    <h4 class="font-bold text-indigo-600 mb-1"><code>$_SERVER</code></h4>
                    <p class="text-sm text-slate-600">サーバーやリクエストの情報（サーバー名・IPアドレス・リクエスト方法・User-Agent など）を取得します。</p>
                </div>
            </div>

            <pre class="language-php mb-6"><code class="language-php">&lt;?php
// $_GET: URLパラメータの取得
// URL例: superglobals.php?name=Yamada
$name = $_GET['name'] ?? 'ゲスト'; // キーがなければ 'ゲスト'

// $_POST: フォームデータの取得
$message = $_POST['message'] ?? '';

// $_SERVER: サーバー情報の取得
$method     = $_SERVER['REQUEST_METHOD']; // "GET" or "POST"
$ip         = $_SERVER['REMOTE_ADDR'];    // アクセス元のIPアドレス
$user_agent = $_SERVER['HTTP_USER_AGENT']; // ブラウザ情報</code></pre>

            <div class="bg-amber-50 border-l-4 border-amber-400 p-4 text-sm text-amber-800 rounded-r-2xl">
                <strong><code>??</code> とは？</strong> Null合体演算子（Null Coalescing Operator）といいます。左辺が <code>null</code> またはキーが存在しない場合に右辺の値を返します。スーパーグローバルと組み合わせてよく使います。
            </div>
        </section>

        <!-- Section 6: Constants -->
        <section class="mb-16">
            <h3 class="text-2xl font-bold text-slate-900 mb-6 flex items-center">
                <span class="w-8 h-8 bg-amber-500 text-white rounded-lg flex items-center justify-center mr-3 text-sm">6</span>
                定数（Constants）
            </h3>
            <p class="mb-4">値を変えたくない場合は、変数ではなく <strong>定数</strong> を使います。定数には <code>$</code> は不要で、慣習として <strong>大文字スネークケース</strong> で名前をつけます。</p>
            <pre class="language-php mb-6"><code class="language-php">&lt;?php
// const で定数を定義（クラス内でも使える）
const TAX_RATE    = 0.1;
const SITE_NAME   = "PHPサンプル";

// define() でも定義できる（実行時に決まる値に使う）
define('MAX_LOGIN_ATTEMPTS', 5);

// 定数は $ なしで呼び出す
echo TAX_RATE;  // → 0.1
echo SITE_NAME; // → PHPサンプル</code></pre>

            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 text-sm text-blue-800 rounded-r-2xl">
                <strong>変数との違い：</strong> 定数は一度定義したら上書きできません。税率・サイト名・APIエンドポイントなど、アプリ全体で固定すべき値に使います。
            </div>
        </section>

        <footer class="pt-12 border-t border-slate-200 text-center">
            <p class="text-slate-500 text-sm italic">"適切なデータ型を選ぶことは、バグの少ない安全なプログラムへの第一歩です。"</p>
        </footer>
    </main>

    <!-- Prism.js Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-markup-templating.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-php.min.js"></script>
</body>

</html>
