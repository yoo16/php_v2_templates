<?php
require_once 'models/AquaCard.php';
require_once 'models/ForestCard.php';
require_once 'models/KnightCard.php';
require_once 'models/ThunderCard.php';

// セッションの開始
session_start();

// カードクラスのインスタンスを生成
$aquaCard = new AquaCard();
$forestCard = new ForestCard();
$knightCard = new KnightCard();
$thunderCard = new ThunderCard();

// TODO: カードの配列
$cards = [
    'aqua' => null,
    'forest' => null,
    'knight' => null,
    'thunder' => null,
];

// カードIDの取得
$card_id = $_GET['card_id'] ?? '';
if (!$card_id) {
    header('Location: card_list.php');
    exit;
}
// リセット
$is_reset = $_GET['reset'] ?? false;
if ($is_reset) {
    unset($_SESSION['cards'][$card_id]);
}

// セッションからカードインスタンスを生成
$card = $_SESSION['cards'][$card_id] ?? null;
// セッションにカードインスタンスがない場合は、カードクラスからインスタンスを生成
if (!$card) $card = $cards[$card_id];

// 経験値の獲得
if (isset($_GET['exp'])) {
    $card->gainExp($_GET['exp']);
    if ($card->isLevelUp()) $card->levelUp();
    // セッションに保存
    $_SESSION['cards'][$card_id] = $card;
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>インスタンスの確認</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="css/game.css">
</head>

<body class="bg-slate-400 text-slate-100 min-h-screen">
    <main class="max-w-4xl mx-auto px-4 py-10">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-game font-black text-transparent bg-clip-text bg-gradient-to-r from-sky-400 to-cyan-400 tracking-widest uppercase mb-4">Instance Profile</h1>
            <p class="text-slate-300">クラスから生成された「実体（インスタンス）」の状態を確認します。</p>
        </div>

        <div class="flex flex-col md:flex-row gap-8 items-center md:items-stretch justify-center">
            <!-- 左側：カードビジュアル -->
            <div class="w-64 flex-shrink-0">
                <div class="tcg-card rounded-2xl p-2 shadow-2xl">
                    <?php include 'views/card.php'; ?>
                </div>
                <div class="mt-4 flex flex-col gap-2">
                    <a href="?card_id=<?= $card_id ?>&exp=10" class="bg-slate-800 hover:bg-slate-700 px-4 py-2 rounded-md">経験値獲得</a>
                    <a href="?card_id=<?= $card_id ?>&reset=1" class="bg-slate-800 hover:bg-slate-700 px-4 py-2 rounded-md">リセット</a>
                    <a href="card_list.php" class="bg-slate-800 hover:bg-slate-700 px-4 py-2 rounded-md">カード一覧に戻る</a>
                </div>
            </div>

            <!-- 右側：詳細ステータス -->
            <div class="flex-1 bg-slate-900/80 rounded-2xl p-6 border border-slate-700 shadow-xl">
                <div class="flex justify-between items-center mb-6 border-b border-slate-700 pb-4">
                    <h2 class="text-xl font-game font-bold text-sky-400">Object Details</h2>
                    <span class="px-3 py-1 bg-sky-900/50 text-sky-300 border border-sky-700 rounded-full text-[10px] font-game">
                        Class: <?= get_class($card) ?>
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <?php
                    $stats = [
                        'Name' => $card->name,
                        'Level' => $card->level,
                        'HP' => "{$card->hp} / {$card->maxHp}",
                        'MP' => "{$card->mp} / {$card->maxMp}",
                        'Attack' => $card->attack,
                        'Defense' => $card->defense,
                        'Element' => $card->element,
                        'Experience' => $card->exp,
                        'Skill' => $card->specialSkill,
                        'Skill Power' => $card->specialSkillPower,
                    ];

                    foreach ($stats as $label => $value):
                    ?>
                        <div class="bg-slate-800/50 p-3 rounded border border-slate-700/50">
                            <p class="text-[9px] font-game text-slate-500 uppercase mb-1 tracking-tighter"><?= $label ?></p>
                            <p class="text-sm font-bold text-slate-200"><?= $value ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

    </main>
</body>

</html>