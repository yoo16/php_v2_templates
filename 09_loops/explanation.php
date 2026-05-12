<?php
$title = '繰り返し処理（Loops）';
$description = '同じ処理を何度も実行したり、配列の中身を一つずつ取り出したりするための構文です。foreach・for・while の使い分けを、ビンゴカードとローン計算の実例で学びましょう。';
$lesson_number = 6;
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>解説：繰り返し処理 | PHP Loops</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Prism.js for code highlighting -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-okaidia.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="bg-slate-50 text-slate-800 leading-relaxed antialiased">

    <?php include '../components/nav.php'; ?>

    <main class="max-w-4xl mx-auto px-6 py-12">
        <?php include '../components/header.php'; ?>

        <!-- Section 1: foreach -->
        <section class="mb-16">
            <h3 class="text-2xl font-bold text-slate-900 mb-6 flex items-center">
                <span class="w-8 h-8 bg-indigo-500 text-white rounded-lg flex items-center justify-center mr-3 text-sm">1</span>
                foreach 文（配列の反復処理）
            </h3>
            <p class="mb-4">配列の各要素を先頭から順番に取り出して処理します。PHPで最もよく使われるループ構文で、<code>bingo.php</code> でも各列のラベルや数値を1枚ずつ描画するために使っています。</p>

            <pre class="language-php mb-6"><code class="language-php">&lt;?php
$labels = ['B', 'I', 'N', 'G', 'O'];

// 基本形：値だけ取り出す
foreach ($labels as $label) {
    echo $label; // B, I, N, G, O と順番に出力
}

// キーと値を同時に取り出す
$ranges = [
    'B' => range(1, 15),
    'I' => range(16, 30),
];

foreach ($ranges as $label => $range) {
    echo $label . '列の範囲: ' . $range[0] . '〜' . end($range);
}</code></pre>

            <h4 class="font-bold text-slate-900 mb-3 mt-8">HTML テンプレートでのコロン構文</h4>
            <p class="mb-4">HTML の中に PHP ループを埋め込む場合、<code>{ }</code> の代わりに <code>:</code> と <code>endforeach;</code> を使うと、開始・終了の対応が分かりやすくなります。<code>bingo.php</code> の描画部分はすべてこの書き方を使っています。</p>
            <pre class="language-php mb-6"><code class="language-php">&lt;ul&gt;
&lt;?php foreach ($labels as $label): ?&gt;
    &lt;li&gt;&lt;?= $label ?&gt;&lt;/li&gt;
&lt;?php endforeach; ?&gt;
&lt;/ul&gt;</code></pre>

            <div class="bg-indigo-50 border-l-4 border-indigo-400 p-4 text-sm text-indigo-800 rounded-r-2xl">
                <strong>使いどき：</strong> 「配列の中身を全部処理したい」場面はほぼ <code>foreach</code> 一択です。配列の長さを気にする必要がなく、最後の要素まで自動的に処理します。
            </div>
        </section>

        <!-- Section 2: for -->
        <section class="mb-16">
            <h3 class="text-2xl font-bold text-slate-900 mb-6 flex items-center">
                <span class="w-8 h-8 bg-indigo-500 text-white rounded-lg flex items-center justify-center mr-3 text-sm">2</span>
                for 文（回数指定の繰り返し）
            </h3>
            <p class="mb-4">「<strong>ちょうど5回繰り返す</strong>」など、あらかじめ回数が決まっている場合に使います。<code>bingo.php</code> では5×5のビンゴカードを行単位で組み立てるために使っています。</p>

            <pre class="language-php mb-6"><code class="language-php">&lt;?php
// (初期化; 条件式; 増減式) の3つをセミコロンで区切る
for ($i = 0; $i < 5; $i++) {
    echo $i . '行目' . PHP_EOL;
}
// 出力: 0行目 1行目 2行目 3行目 4行目

// bingo.php での実例：縦データを横（行）に変換
$rows = [];
for ($i = 0; $i < 5; $i++) {
    foreach ($labels as $label) {
        $rows[$i][] = $columns[$label][$i];
    }
}</code></pre>

            <div class="overflow-x-auto rounded-2xl border border-slate-200 shadow-sm mb-6">
                <table class="w-full text-sm">
                    <thead class="bg-slate-100 text-slate-600 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="px-6 py-3 text-left">部分</th>
                            <th class="px-6 py-3 text-left">意味</th>
                            <th class="px-6 py-3 text-left">例</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100 font-mono text-xs">
                        <tr>
                            <td class="px-6 py-3 text-indigo-600 font-bold">初期化</td>
                            <td class="px-6 py-3 font-sans text-slate-600">ループ開始前に1回だけ実行</td>
                            <td class="px-6 py-3">$i = 0</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3 text-indigo-600 font-bold">条件式</td>
                            <td class="px-6 py-3 font-sans text-slate-600">各ループの前に評価。false になると終了</td>
                            <td class="px-6 py-3">$i &lt; 5</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3 text-indigo-600 font-bold">増減式</td>
                            <td class="px-6 py-3 font-sans text-slate-600">各ループの最後に実行</td>
                            <td class="px-6 py-3">$i++</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Section 3: Nested Loops -->
        <section class="mb-16">
            <h3 class="text-2xl font-bold text-slate-900 mb-6 flex items-center">
                <span class="w-8 h-8 bg-indigo-500 text-white rounded-lg flex items-center justify-center mr-3 text-sm">3</span>
                ネストしたループ（二重ループ）
            </h3>
            <p class="mb-4">ループの中にさらにループを書くことを <strong>ネスト（入れ子）</strong> といいます。表やグリッドのように「行 × 列」の構造を処理するときに使います。<code>bingo.php</code> の数値グリッド描画はまさにこのパターンです。</p>

            <pre class="language-php mb-6"><code class="language-php">&lt;?php
// bingo.php の数値グリッド描画（外側: 行, 内側: 列）
foreach ($rows as $rowIndex => $row) {
    foreach ($row as $colIndex => $value) {
        $currentLabel = $labels[$colIndex];
        $isFree = ($value === 'FREE');
        // 各セルを描画...
    }
}

// シンプルな例：3×3 の掛け算表
for ($i = 1; $i <= 3; $i++) {
    for ($j = 1; $j <= 3; $j++) {
        echo $i * $j . "\t"; // タブ区切りで出力
    }
    echo PHP_EOL;
}
// 出力:
// 1  2  3
// 2  4  6
// 3  6  9</code></pre>

            <div class="bg-amber-50 border-l-4 border-amber-400 p-4 text-sm text-amber-800 rounded-r-2xl">
                <strong>注意：</strong> ネストが深くなるほどコードは読みにくくなります。3重以上のループは、処理を別の関数に切り出すことを検討しましょう。
            </div>
        </section>

        <!-- Section 4: while -->
        <section class="mb-16">
            <h3 class="text-2xl font-bold text-slate-900 mb-6 flex items-center">
                <span class="w-8 h-8 bg-indigo-500 text-white rounded-lg flex items-center justify-center mr-3 text-sm">4</span>
                while 文（条件による繰り返し）
            </h3>
            <p class="mb-4">「<strong>条件が真である間</strong>、処理を繰り返す」ループです。ローンの返済回数のように、終わりが計算前には決まらないケースに適しています。<code>calculate_loan.php</code> ではローン残高が 0 になるまで毎月の計算を繰り返しています。</p>

            <pre class="language-php mb-6"><code class="language-php">&lt;?php
$loan         = 20000000; // 借入額（2000万円）
$pay_by_month = 80000;    // 月々の支払額
$interest_rate = 1.5;     // 年利（%）
$month_count  = 0;
$total_interest = 0;

// ローン残高が 0 より大きい間、かつ最大1000ヶ月を上限に繰り返す
while ($loan > 0 && $month_count < 1000) {
    $month_count++;

    // 月利を計算（年利 ÷ 12）
    $interest = ($loan * $interest_rate / 100) / 12;

    if ($loan + $interest < $pay_by_month) {
        // 最終月：残高と利息の合計を支払って完済
        $loan = 0;
    } else {
        // 通常月：支払額から利息を引いた分だけ元金が減る
        $loan -= ($pay_by_month - $interest);
    }

    $total_interest += $interest;
}</code></pre>

            <div class="bg-rose-50 border-l-4 border-rose-400 p-4 text-sm text-rose-800 rounded-r-2xl">
                <strong>無限ループに注意：</strong> 条件が永遠に <code>true</code> のままだと、プログラムが止まりません。<code>calculate_loan.php</code> では <code>&& $month_count &lt; 1000</code> という <strong>安全上限</strong> を設けています。また、月々の支払額が最初の月の利息を下回る場合はループに入る前にエラーチェックを行っています。
            </div>
        </section>

        <!-- Section 5: break / continue -->
        <section class="mb-16">
            <h3 class="text-2xl font-bold text-slate-900 mb-6 flex items-center">
                <span class="w-8 h-8 bg-indigo-500 text-white rounded-lg flex items-center justify-center mr-3 text-sm">5</span>
                ループの制御：break / continue
            </h3>
            <p class="mb-4">ループの途中で処理を <strong>中断</strong> したり <strong>スキップ</strong> したりするための命令です。</p>

            <pre class="language-php mb-6"><code class="language-php">&lt;?php
// break：ループを即座に終了する
for ($i = 0; $i < 10; $i++) {
    if ($i === 5) {
        break; // $i が 5 になった時点でループを抜ける
    }
    echo $i; // 0, 1, 2, 3, 4 だけ出力される
}

// continue：その回をスキップして次のループへ
for ($i = 0; $i < 5; $i++) {
    if ($i === 2) {
        continue; // $i === 2 のときだけスキップ
    }
    echo $i; // 0, 1, 3, 4 が出力される（2は出ない）
}

// calculate_loan.php での活用：% 演算子で年次データだけ記録
if ($month_count % 12 === 0 || $loan <= 0) {
    $values[] = ['month' => $month_count, 'loan' => $loan];
}</code></pre>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-slate-50 border border-slate-200 p-4 rounded-2xl text-sm">
                    <p class="font-bold text-slate-800 mb-1"><code>break</code></p>
                    <p class="text-slate-600">ループ全体を終了。「見つかったら止める」検索処理などに使う。</p>
                </div>
                <div class="bg-slate-50 border border-slate-200 p-4 rounded-2xl text-sm">
                    <p class="font-bold text-slate-800 mb-1"><code>continue</code></p>
                    <p class="text-slate-600">その回だけスキップして次の反復へ。「偶数だけ処理する」などに使う。</p>
                </div>
            </div>
        </section>

        <!-- Section 6: Array functions -->
        <section class="mb-16">
            <h3 class="text-2xl font-bold text-slate-900 mb-6 flex items-center">
                <span class="w-8 h-8 bg-indigo-500 text-white rounded-lg flex items-center justify-center mr-3 text-sm">6</span>
                ループと相性の良い配列関数
            </h3>
            <p class="mb-4"><code>bingo.php</code> ではループと以下の配列関数を組み合わせることで、ランダムなビンゴカードを生成しています。</p>

            <pre class="language-php mb-6"><code class="language-php">&lt;?php
// range()：連続した数値や文字の配列を生成する
$nums = range(1, 15);    // [1, 2, 3, ..., 15]
$abc  = range('a', 'e'); // ['a', 'b', 'c', 'd', 'e']

// shuffle()：配列の要素をランダムに並び替える（破壊的）
shuffle($nums); // 元の配列を直接並び替える
echo $nums[0];  // ランダムな値

// array_slice()：配列の一部を切り出す
$five = array_slice($nums, 0, 5); // 先頭から5要素を取り出す

// bingo.php での組み合わせ
$ranges = [
    'B' => range(1, 15),
    'I' => range(16, 30),
    // ...
];
foreach ($ranges as $label => $range) {
    shuffle($range);                          // ランダムに並び替え
    $columns[$label] = array_slice($range, 0, 5); // 5つだけ使う
}</code></pre>

            <div class="bg-indigo-50 border-l-4 border-indigo-400 p-4 text-sm text-indigo-800 rounded-r-2xl">
                <strong>破壊的関数に注意：</strong> <code>shuffle()</code> は元の配列を直接変更します（<strong>破壊的関数</strong>）。元の配列を保持したい場合は、先に別の変数にコピーしてから渡しましょう。
            </div>
        </section>

        <footer class="pt-12 border-t border-slate-200 text-center">
            <p class="text-slate-500 text-sm italic">"ループと配列を組み合わせることで、大量のデータを一瞬で処理できるようになります。"</p>
        </footer>
    </main>

    <!-- Prism.js Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-markup-templating.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-php.min.js"></script>
</body>

</html>