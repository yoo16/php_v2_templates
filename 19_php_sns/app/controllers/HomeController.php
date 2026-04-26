<?php

namespace App\Controllers;

use App\Models\Tweet;
use App\Models\Like;
use App\Models\User;
use App\Models\AuthUser;
use Lib\Request;

class HomeController
{
    public function __construct()
    {
        AuthUser::checkLogin();
    }

    public function index()
    {
        $auth_user = AuthUser::get();
        // ツイート一覧は api/tweet/get.php から CSR で取得
        Request::render('home/index', ['auth_user' => $auth_user]);
    }

    public function detail()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ' . BASE_URL . 'home/');
            exit;
        }

        // ツイートデータは api/tweet/fetch.php から CSR で取得
        Request::render('home/detail', ['tweet_id' => (int) $id]);
    }

    public function user_tweets()
    {
        // ユーザセッションの確認し、ログインしていない場合はログイン画面にリダイレクト
        $auth_user = AuthUser::checkLogin();

        // ユーザIDを取得
        $user_id = $_GET['id'] ?? null;

        // ユーザ検索
        $user = new User();
        $user_data = $user->find($user_id);
        if (!$user_data) {
            // ユーザいない場合はホームにリダイレクト
            header('Location: ' . BASE_URL . 'home/');
            exit;
        }
        // ユーザ投稿
        $tweet = new Tweet();
        $tweets = $tweet->getByUserID($user_data['id']);

        // Viewをレンダリング: app/views/home/user_tweets.view.php
        Request::render('home/user_tweets', ['tweets' => $tweets]);
    }

    public function add()
    {
        // POSTデータを取得
        $posts = sanitize($_POST);

        // ログインユーザセッションの確認
        $auth_user = AuthUser::get();

        // 投稿処理
        $tweet = new Tweet();
        $tweet->insert($auth_user['id'], $posts);

        // トップにリダイレクト
        header('Location: ' . BASE_URL . 'home/');
        exit;
    }

    public function search()
    {
        $keyword = h($_GET['keyword'] ?? '');

        // ツイート検索結果は api/tweet/search.php から CSR で取得
        Request::render('home/search', ['keyword' => $keyword]);
    }

    public function like()
    {
        // POSTリクエスト以外は処理しない
        if (!Request::isPost()) {
            header('Location: ' . BASE_URL . 'home/');
            exit;
        }

        $tweet_id = $_POST['tweet_id'] ?? null;
        $user_id = $_POST['user_id'] ?? null;

        if ($tweet_id && $user_id) {
            $like = new Like();
            $like->update($tweet_id, $user_id);
        }

        // ホームにリダイレクト
        header('Location: ' . BASE_URL . 'home/');
        exit;
    }

    public function garally()
    {
        // メディア一覧は api/tweet/garally.php から CSR で取得
        Request::render('home/garally');
    }

    public function delete()
    {
        // POSTリクエスト以外は処理しない
        if (!Request::isPost()) {
            header('Location: ' . BASE_URL . 'home/');
            exit;
        }

        // POSTデータを取得
        $posts = sanitize($_POST);

        // ログインユーザのIDと投稿のユーザIDが一致しない場合はホームにリダイレクト
        $auth_user = AuthUser::get();
        if ((int) $auth_user['id'] !== (int) $posts['user_id']) {
            header('Location: ' . BASE_URL . 'home/');
            exit;
        }

        // 削除処理
        $tweet = new Tweet();
        $tweet->delete($posts['tweet_id']);

        // ホームにリダイレクト
        header('Location: ' . BASE_URL . 'home/');
        exit;
    }
}
