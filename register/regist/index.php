<?php
// 共通ファイル app.php を読み込み
require_once "../app.php";

// ログアウト用
if (isset($_SESSION[APP_KEY]['regist'])) {
    // TODO: unset() でセッション削除: キー: regist
}
header('Location: ./input/');
