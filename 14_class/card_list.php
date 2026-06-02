<?php
require_once 'models/AquaCard.php';
require_once 'models/ForestCard.php';
require_once 'models/KnightCard.php';
require_once 'models/ThunderCard.php';

// TODO: 各カードクラスからインスタンスを生成
$aquaCard = new stdClass();
$forestCard = new stdClass();
$knightCard = new stdClass();
$thunderCard = new stdClass();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>カード選択</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="css/game.css">
</head>

<body class="bg-slate-400 text-slate-100 min-h-screen">
    <main class="max-w-5xl mx-auto px-4 py-10">
        <section class="animate-in fade-in zoom-in duration-700">
            <div class="text-center mb-6">
                <h3 class="text-4xl font-game font-black text-transparent bg-clip-text bg-gradient-to-r from-sky-400 to-cyan-400 tracking-[0.2em] uppercase mb-4">Select Your Unit</h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2">
                <!-- ポリモーフィズム で繰り返し -->
                <a href="card_select.php?card_id=aqua" class="w-full text-left tcg-card rounded-2xl hover:-translate-y-4 hover:scale-105 active:scale-95 duration-500 shadow-2xl shadow-black/50">
                    <?php
                    $card = $aquaCard;
                    include 'views/card.php';
                    ?>
                </a>
                <a href="card_select.php?card_id=forest" class="w-full text-left tcg-card rounded-2xl hover:-translate-y-4 hover:scale-105 active:scale-95 duration-500 shadow-2xl shadow-black/50">
                    <?php
                    $card = $forestCard;
                    include 'views/card.php';
                    ?>
                </a>
                <a href="card_select.php?card_id=knight" class="w-full text-left tcg-card rounded-2xl hover:-translate-y-4 hover:scale-105 active:scale-95 duration-500 shadow-2xl shadow-black/50">
                    <?php
                    $card = $knightCard;
                    include 'views/card.php';
                    ?>
                </a>
                <a href="card_select.php?card_id=thunder" class="w-full text-left tcg-card rounded-2xl hover:-translate-y-4 hover:scale-105 active:scale-95 duration-500 shadow-2xl shadow-black/50">
                    <?php
                    $card = $thunderCard;
                    include 'views/card.php';
                    ?>
                </a>
            </div>
        </section>
    </main>
</body>

</html>