<?php

namespace App\Models;

use PDO;
use PDOException;
use Lib\Database;

class Follow
{
    /**
     * フォロー関係の取得
     *
     * @param int $follower_id フォローするユーザーID
     * @param int $followee_id フォローされるユーザーID
     * @return array|null フォロー情報、存在しなければ null
     */
    public function fetch($follower_id, $followee_id)
    {
        if (empty($follower_id) || empty($followee_id)) {
            return null;
        }
        try {
            $pdo = Database::getInstance();
            $sql = "SELECT * FROM follows
                    WHERE follower_id = :follower_id
                    AND followee_id = :followee_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['follower_id' => $follower_id, 'followee_id' => $followee_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    /**
     * フォローを追加
     */
    public function insert($follower_id, $followee_id)
    {
        try {
            $pdo = Database::getInstance();
            $sql = "INSERT INTO follows (follower_id, followee_id) VALUES (:follower_id, :followee_id)";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute(['follower_id' => $follower_id, 'followee_id' => $followee_id]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }
    }

    /**
     * フォローを削除
     */
    public function delete($follower_id, $followee_id)
    {
        try {
            $pdo = Database::getInstance();
            $sql = "DELETE FROM follows WHERE follower_id = :follower_id AND followee_id = :followee_id";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute(['follower_id' => $follower_id, 'followee_id' => $followee_id]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }
    }

    /**
     * フォローのトグル（フォロー中ならアンフォロー、未フォローならフォロー）
     */
    public function update($follower_id, $followee_id)
    {
        if ($this->fetch($follower_id, $followee_id)) {
            $this->delete($follower_id, $followee_id);
        } else {
            $this->insert($follower_id, $followee_id);
        }
    }

    /**
     * フォロー数（自分がフォローしている数）
     *
     * @param int $user_id ユーザーID
     * @return int フォロー数
     */
    public function countFollowing($user_id)
    {
        try {
            $pdo = Database::getInstance();
            $sql = "SELECT COUNT(*) AS cnt FROM follows WHERE follower_id = :user_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['user_id' => $user_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int) $result['cnt'];
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return 0;
        }
    }

    /**
     * フォロワー数（自分をフォローしている数）
     *
     * @param int $user_id ユーザーID
     * @return int フォロワー数
     */
    public function countFollowers($user_id)
    {
        try {
            $pdo = Database::getInstance();
            $sql = "SELECT COUNT(*) AS cnt FROM follows WHERE followee_id = :user_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['user_id' => $user_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int) $result['cnt'];
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return 0;
        }
    }
}
