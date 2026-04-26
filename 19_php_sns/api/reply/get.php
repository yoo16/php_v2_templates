<?php
require_once '../../app.php';

use App\Models\AuthUser;
use App\Models\Reply;
use App\Models\User;

header('Content-Type: application/json');

// 認証チェック
$auth_user = AuthUser::get();
if (!$auth_user) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized'], JSON_UNESCAPED_UNICODE);
    exit;
}

$tweet_id = isset($_GET['tweet_id']) ? (int) $_GET['tweet_id'] : 0;

if (!$tweet_id) {
    http_response_code(400);
    echo json_encode(['error' => 'Bad Request'], JSON_UNESCAPED_UNICODE);
    exit;
}

$reply   = new Reply();
$replies = $reply->getByTweetId($tweet_id);

if ($replies === null) {
    http_response_code(500);
    echo json_encode(['error' => 'Internal Server Error'], JSON_UNESCAPED_UNICODE);
    exit;
}

foreach ($replies as &$r) {
    $r['profile_image_url'] = User::profileImage($r['profile_image']);
}
unset($r);

echo json_encode($replies, JSON_UNESCAPED_UNICODE);
