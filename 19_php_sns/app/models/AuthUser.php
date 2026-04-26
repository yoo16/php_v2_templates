<?php

namespace App\Models;

class AuthUser extends User
{
    /**
     * 認証ユーザ情報を取得
     *
     * @return array|null 認証ユーザ情報、もしくは該当するユーザがなければ null
     */
    public static function get()
    {
        // セッションから認証ユーザ情報を取得
        $auth_user = $_SESSION[APP_KEY]['auth_user'] ?? null;
        // 認証ユーザ情報が存在しない場合は null を返す
        if (empty($auth_user)) {
            return null;
        }
        // 認証ユーザ情報を返す
        return $auth_user;
    }

    public static function set($auth_user)
    {
        // セッションから認証ユーザ情報を取得
        $_SESSION[APP_KEY]['auth_user'] = $auth_user;
    }

    public static function isLogin()
    {
        // セッションから認証ユーザ情報を取得
        $auth_user = self::get();
        // 認証ユーザ情報が存在する場合は true を返す
        return !empty($auth_user);
    }

    /**
     * ログインチェック
     *
     * @param string $path ログイン画面へのパス
     * @return array|null 認証ユーザ情報、もしくは該当するユーザがなければ null
     */
    public static function checkLogin()
    {
        // セッションから認証ユーザ情報を取得
        $auth_user = self::get();
        // 認証ユーザ情報が存在しない場合はログイン画面にリダイレクト
        if (empty($auth_user)) {
            header('Location: ' . BASE_URL . 'login/');
            exit;
        }
    }

    /**
     * ログアウト処理
     *
     * @param string $path ログイン画面へのパス
     */
    public static function logout($path = '../login/')
    {
        // セッションから認証ユーザ情報を削除
        unset($_SESSION[APP_KEY]['auth_user']);
        // ログアウト処理後のリダイレクト先を指定
        header('Location: ' . $path);
        exit;
    }
}
