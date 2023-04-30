<?php

namespace App\Model;

use PDO;
class UserManager extends AbstractManager
{
    public const TABLE = 'mg_user';

    public function addUser(array $user)
    {


        $statement = $this->pdo->prepare(
            "INSERT INTO " . self::TABLE . "
            (`firstname`, `lastname`, `email`, `mg_password`) VALUES
         (:firstname, :lastname, :email, :password)"
        );

        $statement->bindParam(':firstname', $user['firstname'], \PDO::PARAM_STR);
        $statement->bindParam(':lastname', $user['lastname'], \PDO::PARAM_STR);
        $statement->bindParam(':email', $user['email'], \PDO::PARAM_STR);
        $statement->bindParam(':password', $user['mg_password'], \PDO::PARAM_STR);

        $statement->execute();

        return (int)$this->pdo->lastInsertId();

    }
    public function update(array $user): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `firstname` = :firstname, `lastname` = :lastname,
        `email` = :email, `mg_password` = :password WHERE id = :id");

        $statement->bindValue(':id', $user['id'], PDO::PARAM_INT);
        $statement->bindValue(':firstname', $user['firstname'], PDO::PARAM_STR);
        $statement->bindValue(':lastname', $user['lastname'], PDO::PARAM_STR);
        $statement->bindValue(':email', $user['email'], PDO::PARAM_STR);
        $statement->bindValue(':password', $user['mg_password'], PDO::PARAM_STR);

        return $statement->execute();
    }


}
