<?php
require_once '../../app.php';

use App\Models\AuthUser;
use App\Models\User;

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
$display_name = isset($body['display_name']) ? trim($body['display_name']) : null;
$profile      = isset($body['profile'])      ? trim($body['profile'])      : '';

if (!$display_name) {
    http_response_code(400);
    echo json_encode(['error' => 'ディスプレイ名は必須です'], JSON_UNESCAPED_UNICODE);
    exit;
}

$user = new User();
$result = $user->update((int) $auth_user['id'], [
    'display_name' => $display_name,
    'profile'      => $profile,
]);

if (!$result) {
    http_response_code(500);
    echo json_encode(['error' => '更新に失敗しました'], JSON_UNESCAPED_UNICODE);
    exit;
}

// セッションのユーザ情報を更新
AuthUser::set($user->find((int) $auth_user['id']));

echo json_encode(['success' => true], JSON_UNESCAPED_UNICODE);
