<?php
require_once '../../app.php';

use App\Models\AuthUser;
use App\Models\Like;
use App\Models\Tweet;
use App\Models\User;

header('Content-Type: application/json');

// 認証チェック
$auth_user = AuthUser::get();
if (!$auth_user) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized'], JSON_UNESCAPED_UNICODE);
    exit;
}

// ページネーションパラメータ
$limit  = isset($_GET['limit'])  ? (int) $_GET['limit']  : 10;
$offset = isset($_GET['offset']) ? (int) $_GET['offset'] : 0;

// ツイート取得
$tweet  = new Tweet();
$tweets = $tweet->get($limit, $offset);

// profile_image_url・liked を付与し、空の image_path を null に統一
if ($tweets) {
    $like = new Like();
    foreach ($tweets as &$t) {
        $t['profile_image_url'] = User::profileImage($t['profile_image']);
        $t['liked']             = (bool) $like->fetch($t['id'], $auth_user['id']);
        if (empty($t['image_path'])) {
            $t['image_path'] = null;
        }
    }
    unset($t);
}

echo json_encode($tweets ?? [], JSON_UNESCAPED_UNICODE);
