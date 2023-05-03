<?php

namespace App\Model;

use PDO;

class UserManager extends AbstractManager
{
    public const TABLE = 'p2_user';

    public function addUser(array $user)
    {
        $firstname = htmlspecialchars($_POST['p2_firstname'], ENT_QUOTES, 'UTF-8');
        $lastname = htmlspecialchars($_POST['p2_lastname'], ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars($_POST['p2_email'], ENT_QUOTES, 'UTF-8');
        $passwordHash = password_hash($user['p2_password'], PASSWORD_DEFAULT);
        $birthday = ($_POST['p2_birthday']);

        $sql = "INSERT INTO " . self::TABLE . " (p2_firstname, p2_lastname, p2_email, p2_password, p2_birthday)
            VALUES (:p2_firstname, :p2_lastname, :p2_email, :p2_password, :p2_birthday)";

        $statement = $this->pdo->prepare($sql);

        $statement->bindParam('p2_firstname', $firstname, PDO::PARAM_STR);
        $statement->bindParam('p2_lastname', $lastname, PDO::PARAM_STR);
        $statement->bindParam('p2_email', $email, PDO::PARAM_STR);
        $statement->bindParam('p2_password', $passwordHash, PDO::PARAM_STR);
        $statement->bindParam('p2_birthday', $birthday, PDO::PARAM_STR);
        // $statement->bindParam('userPicture_id', $pictureID, PDO::PARAM_INT);

        $statement->execute();
    }

    public function edit(array $user)
    {
        $sql = "UPDATE " . self::TABLE . " SET
        p2_firstname = :p2_firstname,
        p2_lastname = :p2_lastname,
        p2_email = :p2_email,
        p2_password = :p2_password,
        p2_birthday = :p2_birthday
        WHERE id=:id";

        $statement = $this->pdo->prepare($sql);

        $passwordHash = password_hash($user['p2_password'], PASSWORD_DEFAULT);

        $statement->bindParam(':p2_firstname', $user['p2_firstname'], PDO::PARAM_STR);
        $statement->bindParam(':p2_lastname', $user['p2_lastname'], PDO::PARAM_STR);
        $statement->bindParam(':p2_email', $user['p2_email'], PDO::PARAM_STR);
        $statement->bindParam(':p2_password', $passwordHash, PDO::PARAM_STR);
        $statement->bindParam(':p2_birthday', $user['p2_birthday'], PDO::PARAM_STR);
        $statement->bindParam(':id', $user['id'], PDO::PARAM_INT);

        $statement->execute();

        return $statement->fetch();
    }
}
