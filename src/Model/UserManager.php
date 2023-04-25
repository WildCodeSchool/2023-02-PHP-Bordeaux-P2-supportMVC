<?php

namespace App\Model;

class UserManager extends AbstractManager
{
    public const TABLE = 'ff_user';

    public function addUser(array $user)
    {
        $sql = "INSERT INTO ff_user(firstname, lastname, email, ff_password) VALUES (:firstname, :lastname, :email, :password)";

        $statement = $this->pdo->prepare($sql);

        $statement->bindParam(':firstname', $user['firstname'], \PDO::PARAM_STR);
        $statement->bindParam(':lastname', $user['lastname'], \PDO::PARAM_STR);
        $statement->bindParam(':email', $user['ff_email'], \PDO::PARAM_STR);
        $statement->bindParam(':password', $user['ff_password'], \PDO::PARAM_STR);

        $statement->execute();
    }
}
