<?php
require_once '../../app.php';

use App\Models\AuthUser;
use App\Models\Follow;

header('Content-Type: application/json');

// 認証チェック
$auth_user = AuthUser::get();
if (!$auth_user) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized'], JSON_UNESCAPED_UNICODE);
    exit;
}

// POST のみ受け付け
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed'], JSON_UNESCAPED_UNICODE);
    exit;
}

$body = json_decode(file_get_contents('php://input'), true);
$followee_id = isset($body['followee_id']) ? (int) $body['followee_id'] : null;

if (!$followee_id) {
    http_response_code(400);
    echo json_encode(['error' => 'Bad Request'], JSON_UNESCAPED_UNICODE);
    exit;
}

$follower_id = (int) $auth_user['id'];

// 自分自身はフォローできない
if ($follower_id === $followee_id) {
    http_response_code(400);
    echo json_encode(['error' => 'Cannot follow yourself'], JSON_UNESCAPED_UNICODE);
    exit;
}

$follow = new Follow();

// フォローをトグル
$follow->update($follower_id, $followee_id);

// トグル後の状態を返す
$following = (bool) $follow->fetch($follower_id, $followee_id);
$follower_count = $follow->countFollowers($followee_id);

echo json_encode([
    'following'      => $following,
    'follower_count' => $follower_count,
], JSON_UNESCAPED_UNICODE);
