<?php
require_once '../app.php';

// TODO: セッションの APP_KEY 下の auth_user を削除
if (isset($_SESSION[APP_KEY]['auth_user'])) {
    unset($_SESSION[APP_KEY]['auth_user']);
}

// TODO: ログイン画面にリダイレクト
header('Location: ../login/');
