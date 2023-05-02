<?php

namespace App\Model;

use PDO;

class UserManager extends AbstractManager
{
    public const TABLE = 'support_user';
    /**
     * Insert new user in database
     */
    public function insert(array $user): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`id`,`lastname`,`firstname`,`email`,`birth_date`)
         VALUES (:id, :lastname, :firstname, :email, :birth_date)");

        $statement->bindValue(':id', $user['id'], PDO::PARAM_INT);
        $statement->bindValue(':lastname', $user['lastname'], PDO::PARAM_STR);
        $statement->bindValue(':firstname', $user['firstname'], PDO::PARAM_STR);
        $statement->bindValue(':email', $user['email'], PDO::PARAM_STR);
        $statement->bindValue(':birth_date', $user['birthdate'], PDO::PARAM_STR);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

/**
 * Update user in database
 */
    public function update(array $user): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `lastname` = :lastname,`firstname` = :firstname,`email` = :email,`birth_date` = :birth_date WHERE id=:id");

        $statement->bindValue(':id', $user['id']);
        $statement->bindValue(':lastname', $user['lastname']);
        $statement->bindValue(':firstname', $user['firstname']);
        $statement->bindValue(':email', $user['email']);
        $statement->bindValue(':birth_date', $user['birthdate']);

        return $statement->execute();
    }
}
