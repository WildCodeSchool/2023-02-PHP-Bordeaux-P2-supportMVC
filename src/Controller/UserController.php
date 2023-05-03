<?php

namespace App\Controller;

use App\Model\UserManager;
use RangeException;

class UserController extends AbstractController
{
    public function index(): string
    {
        $userManager = new UserManager();
        $users = $userManager->selectAll();

        return $this->twig->render('User/index.html.twig', ['users' => $users]);
    }

    public function add(): string
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstname = htmlspecialchars($_POST['p2_firstname'], ENT_QUOTES, 'UTF-8');
            $lastname = htmlspecialchars($_POST['p2_lastname'], ENT_QUOTES, 'UTF-8');
            $email = htmlspecialchars($_POST['p2_email'], ENT_QUOTES, 'UTF-8');
            $password = ($_POST['p2_password']);
            $birthday = ($_POST['p2_birthday']);
            $impossibleBirthday = "1910-01_01";

            if (trim($firstname) === '') {
                $errors [] = 'Firstname is mandatory';
            }
            if (strlen($firstname) > 100) {
                $errors [] = 'Firstname should be 100 characters max';
            }
            if (trim($lastname) == '') {
                $errors [] = 'Lastname is mandatory';
            }
            if (strlen($lastname) > 100) {
                $errors [] = 'Firstname should be 100 characters max';
            }
            if (trim($email) === '') {
                $errors [] = 'Email is mandatory';
            }
            if (strlen($email) > 100) {
                $errors [] = 'email should be 100 characters max';
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors [] = 'Invalid email address';
            }
            if (!isset($password) || trim($password) === '') {
                $errors [] = 'Password is mandatory';
            }
            if (strlen($password) > 50 || strlen($password) < 5) {
                $errors [] = 'Password should be between 5 and 50 characters long';
            }
            if (!isset($birthday)) {
                $errors [] = 'Birthday is mandatory';
            }
            if ($birthday < $impossibleBirthday) {
                $errors [] = 'Please enter a valid birth date';
            }

            if (empty($errors)) {
                $userManager = new UserManager();
                $userManager->addUser($_POST);
            }
        }
        $user = array_map('trim', ($_POST));
        return $this->twig->render('User/add.html.twig', ['user' => $user, 'errors' => $errors]);
    }

    public function show($id): string
    {
        $userManager = new UserManager();
        $user = $userManager->selectOneById($id);

        return $this->twig->render('User/show.html.twig', ['user' => $user]);
    }

    public function edit($id): string
    {
        $userManager = new UserManager();
        $user = $userManager->selectOneById($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //echo 'post ok';
            //die();
            //var_dump($_POST);
            $userManager->edit($_POST);
            header("Location: /users/show?id=" . $user["id"]);
        }
        //var_dump($user);
        return $this->twig->render('User/edit.html.twig', ['user' => $user,]);
    }

    public function delete(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);
            $userManager = new UserManager();
            $userManager->delete((int)$id);

            header('Location:/users');
        }
    }
}
