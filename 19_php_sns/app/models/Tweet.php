<?php

namespace App\Models;

use PDO;
use PDOException;
use RuntimeException;
use Lib\Database;
use Lib\File;

class Tweet
{
    private ?string $lastError = null;

    public function getLastError(): ?string
    {
        return $this->lastError;
    }

    /**
     * 投稿データを取得
     *
     * @return array|null 投稿データの連想配列、もしくは該当する投稿がなければ null
     */
    public function get($limit = 10, $offset = 0)
    {
        return $this->fetchTweets('', [], $limit, $offset);
    }

    public function getByUserID($user_id, $limit = 50)
    {
        return $this->fetchTweets('tweets.user_id = :user_id', ['user_id' => $user_id], $limit);
    }

    /**
     * キーワード検索して取得
     *
     * @return array|null 投稿データの連想配列、もしくは該当する投稿がなければ null
     */
    public function search($keyword, $limit = 50)
    {
        // # 直後のスペース有無を正規化して両方にマッチさせる
        // 例: "#anime" → "%#anime%" と "%# anime%" の両方を検索
        $normalized = preg_replace('/#\s+/', '#', $keyword);   // "# anime" → "#anime"
        $spaced     = preg_replace('/#(?=\S)/', '# ', $normalized); // "#anime" → "# anime"

        $where  = '(tweets.message LIKE :keyword OR tweets.message LIKE :keyword_spaced)';
        $params = [
            'keyword'        => "%{$normalized}%",
            'keyword_spaced' => "%{$spaced}%",
        ];
        return $this->fetchTweets($where, $params, $limit);
    }

    private function fetchTweets(string $where, array $params, int $limit, int $offset = 0): ?array
    {
        try {
            $pdo = Database::getInstance();
            $sql = "SELECT
                    tweets.id,
                    tweets.message,
                    tweets.user_id,
                    tweets.image_path,
                    tweets.created_at,
                    tweets.updated_at,
                    users.account_name,
                    users.display_name,
                    users.profile_image,
                    COUNT(DISTINCT likes.id) AS like_count,
                    COUNT(DISTINCT replies.id) AS reply_count
                FROM tweets
                JOIN users ON tweets.user_id = users.id
                LEFT JOIN likes ON tweets.id = likes.tweet_id
                LEFT JOIN replies ON tweets.id = replies.tweet_id"
                . ($where ? " WHERE {$where}" : "")
                . " GROUP BY
                    tweets.id,
                    tweets.message,
                    tweets.user_id,
                    tweets.image_path,
                    tweets.created_at,
                    tweets.updated_at,
                    users.account_name,
                    users.display_name,
                    users.profile_image
                ORDER BY tweets.created_at DESC
                LIMIT :limit OFFSET :offset";
            $params['limit']  = $limit;
            $params['offset'] = $offset;
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    /**
     * 投稿データを取得
     *
     * @param int $id 投稿ID
     * @return array|null 投稿データの連想配列、もしくは該当する投稿がなければ null
     */
    public function find(int $id)
    {
        try {
            $pdo = Database::getInstance();
            $sql = "SELECT * FROM tweets WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['id' => $id]);
            $value = $stmt->fetch(PDO::FETCH_ASSOC);
            return $value;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    /**
     * 投稿データを取得
     *
     * @param int $id 投稿ID
     * @return array|null 投稿データの連想配列、もしくは該当する投稿がなければ null
     */
    public function findWithUser(int $id)
    {
        try {
            $pdo = Database::getInstance();
            $sql = "SELECT tweets.*,
                            users.display_name,
                            users.account_name,
                            users.profile_image
                    FROM tweets
                    JOIN users ON tweets.user_id = users.id
                    WHERE tweets.id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['id' => $id]);
            $value = $stmt->fetch(PDO::FETCH_ASSOC);
            return $value;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    /**
     * ユーザデータをDBに登録する
     *
     * @param int $user_id ユーザID
     * @param array $data 登録する投稿データ
     * @return mixed 登録成功時は投稿ID、失敗時は null
     */
    public function insert($user_id, $data)
    {
        $this->lastError = null;

        try {
            $data['user_id'] = $user_id;
            $data['image_path'] = $this->uploadImage();

            $pdo = Database::getInstance();
            $sql = "INSERT INTO tweets (user_id, message, image_path)
                    VALUES (:user_id, :message, :image_path)";

            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute($data);
            if ($result) {
                return $pdo->lastInsertId();
            }
            $this->lastError = 'tweet insert execute returned false';
        } catch (RuntimeException $e) {
            $this->lastError = $e->getMessage();
            error_log($e->getMessage());
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            error_log($e->getMessage());
        }
        return;
    }

    /**
     * 投稿データを削除
     *
     * @param int $tweet_id 投稿ID
     * @return mixed
     */
    public function delete($id)
    {
        try {
            $pdo = Database::getInstance();
            $sql = "DELETE FROM tweets WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }
        return;
    }

    /**
     * 投稿データのカウント
     *
     * @param int $user_id ユーザID
     * @return mixed
     */
    public function countByUserID($user_id)
    {
        try {
            $pdo = Database::getInstance();
            $sql = "SELECT COUNT(*) FROM tweets WHERE user_id = :user_id;";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['user_id' => $user_id]);
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }
        return;
    }

    /**
     * 画像データを取得
     *
     * @return array|null 画像データの連想配列、もしくは該当する画像がなければ null
     */
    public function getImages()
    {
        try {
            $pdo = Database::getInstance();
            $sql = "SELECT id, image_path FROM tweets
                    WHERE image_path IS NOT NULL AND image_path != ''
                    ORDER BY created_at DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    /**
     * アップロード画像を取得
     *
     * @param int $id 投稿ID
     * @return bool 成功した場合は画像ファイルパス、失敗した場合は null
     */
    public function uploadImage()
    {
        if (!isset($_FILES['file']) || $_FILES['file']['error'] === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            throw new RuntimeException('image upload error code: ' . $_FILES['file']['error']);
        }

        return File::upload(UPLOADS_BASE);
    }
}
