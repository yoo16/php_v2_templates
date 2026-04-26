<?php

namespace Lib;

class Request
{
    /**
     * POSTリクエストかどうかを返す
     * @return bool
     */
    public static function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    /**
     * Viewファイルを表示する
     * @param string $path Viewファイルのパス
     * @param array $data Viewファイルに渡す変数
     */
    public static function render(string $path, array $data = [])
    {
        // Viewファイルを指定
        $view = VIEW_DIR . $path . '.view.php';

        // 変数を展開
        extract($data);

        // Viewファイルを読み込む（出力をバッファリングしてキャプチャ）
        ob_start();
        require_once $view;
        $content = ob_get_clean();

        // レイアウトファイルを読み込む
        require_once VIEW_DIR . 'layout.view.php';
    }
}
