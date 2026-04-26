<?php
require_once '../../app.php';

use App\Models\AuthUser;
use App\Models\Tweet;
use App\Models\User;

header('Content-Type: application/json');

function respondJson(int $status, array $payload): void
{
    http_response_code($status);
    echo json_encode($payload, JSON_UNESCAPED_UNICODE);
    exit;
}

$auth_user = AuthUser::get();
if (!$auth_user) {
    respondJson(401, ['error' => 'Unauthorized']);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respondJson(405, ['error' => 'Method Not Allowed']);
}

$message = trim($_POST['message'] ?? '');
if ($message === '') {
    respondJson(400, ['error' => 'メッセージを入力してください']);
}

$tweet = new Tweet();
$tweet_id = $tweet->insert($auth_user['id'], ['message' => $message]);

if (!$tweet_id) {
    respondJson(500, ['error' => '投稿に失敗しました']);
}

$data = $tweet->findWithUser((int) $tweet_id);
if (!$data) {
    respondJson(500, ['error' => '投稿データの取得に失敗しました']);
}

$data['like_count'] = 0;
$data['liked'] = false;
$data['profile_image_url'] = User::profileImage($data['profile_image']);
$data['image_path'] = empty($data['image_path']) ? null : $data['image_path'];

respondJson(200, $data);
