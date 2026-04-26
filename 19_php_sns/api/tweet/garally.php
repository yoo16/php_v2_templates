<?php
require_once '../../app.php';

use App\Models\AuthUser;
use App\Models\Tweet;

header('Content-Type: application/json');

$auth_user = AuthUser::get();
if (!$auth_user) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized'], JSON_UNESCAPED_UNICODE);
    exit;
}

$tweet = new Tweet();
$tweets = $tweet->getImages();

echo json_encode($tweets ?? [], JSON_UNESCAPED_UNICODE);
