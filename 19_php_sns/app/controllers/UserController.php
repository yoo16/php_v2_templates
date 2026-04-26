<?php

namespace App\Controllers;

use App\Models\Tweet;
use App\Models\User;
use App\Models\AuthUser;
use App\Models\Follow;
use Lib\Request;

class UserController
{
    public function __construct()
    {
        AuthUser::checkLogin();
    }

    public function update()
    {
        if (!Request::isPost()) {
            header('Location: ' . BASE_URL . 'user/edit.php');
            exit;
        }

        $auth_user = AuthUser::get();
        $posts = sanitize($_POST);

        $user = new User();
        $user->update($auth_user['id'], $posts);

        // ユーザ情報をセッションに保存
        AuthUser::set($user->find($auth_user['id']));

        header('Location: ' . BASE_URL . 'user/edit.php');
        exit;
    }

    public function edit()
    {
        $auth_user = AuthUser::get();

        // ユーザ情報をDBから再読み込み
        $user = new User();
        $auth_user = $user->find($auth_user['id']);

        // Viewをレンダリング: app/views/user/edit.view.php
        Request::render('user/edit', ['auth_user' => $auth_user]);
    }

    public function follow()
    {
        if (!Request::isPost()) {
            header('Location: ' . BASE_URL . 'user/');
            exit;
        }

        $auth_user   = AuthUser::get();
        $followee_id = (int) ($_POST['followee_id'] ?? 0);

        if ($followee_id && $followee_id !== (int) $auth_user['id']) {
            $follow = new Follow();
            $follow->insert($auth_user['id'], $followee_id);
        }

        header('Location: ' . BASE_URL . 'user/?id=' . $followee_id);
        exit;
    }

    public function unfollow()
    {
        if (!Request::isPost()) {
            header('Location: ' . BASE_URL . 'user/');
            exit;
        }

        $auth_user   = AuthUser::get();
        $followee_id = (int) ($_POST['followee_id'] ?? 0);

        if ($followee_id) {
            $follow = new Follow();
            $follow->delete($auth_user['id'], $followee_id);
        }

        header('Location: ' . BASE_URL . 'user/?id=' . $followee_id);
        exit;
    }

    public function index()
    {
        $auth_user = AuthUser::get();
        $user_id = $_GET['id'] ?? $auth_user['id'];

        $user = new User();
        $user_data = $user->find($user_id);
        if (!$user_data) {
            header('Location: ' . BASE_URL . 'home/');
            exit;
        }

        $tweet = new Tweet();
        $tweet_count = $tweet->countByUserID($user_data['id']);

        $follow = new Follow();
        $follow_count    = $follow->countFollowing($user_data['id']);
        $follower_count  = $follow->countFollowers($user_data['id']);
        $is_following    = (bool) $follow->fetch($auth_user['id'], $user_data['id']);

        // Viewをレンダリング: app/views/user/index.view.php
        Request::render('user/index', [
            'auth_user'      => $auth_user,
            'user_data'      => $user_data,
            'tweet_count'    => $tweet_count,
            'follow_count'   => $follow_count,
            'follower_count' => $follower_count,
            'is_following'   => $is_following,
        ]);
    }
}
