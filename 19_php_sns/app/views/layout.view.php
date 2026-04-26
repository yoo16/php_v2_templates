<!DOCTYPE html>
<html lang="ja">

<!-- TODO: コンポーネント: components/head.php -->
<?php include COMPONENT_DIR . 'head.php' ?>

<body class="bg-white text-slate-900 antialiased">
    <?php if (isset($auth_user)) : ?>
    <?php else: ?>
        <?php include COMPONENT_DIR . 'public_nav.php' ?>
    <?php endif ?>

    <?= $content ?>

</body>

</html>