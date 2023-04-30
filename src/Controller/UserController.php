<?php

namespace App\Controller;

use App\Model\UserManager;

class UserController extends AbstractController
{
    public function index()
    {
        $userManager = new UserManager();
        $users = $userManager->selectAll();
        return $this->twig->render('User/index.html.twig', [
            'users' => $users,
        ]);
    }
    public function edit(int $id): ?string
    {
        $userManager = new UserManager();
        $user = $userManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $user = array_map('trim', $_POST);

            // TODO validations (length, format...)
            $errors = $this->validateUser($user);

            if (empty($errors)) {

                $userManager->update($user);
                header('Location: /users/show?id=' . $id);

                return null;
            } else {

                return $this->twig->render('User/edit.html.twig', [
                    'user' => $user,
                    'errors' => $errors
                ]);
            }
        }

        // display the form with the current user data
        return $this->twig->render('User/edit.html.twig', [
            'user' => $user
        ]);
    }

    private function validateUser(array $user): array
    {
        $errors = [];

        // validate username
        if (empty($user['firstname'])) {
            $errors['firstname'] = 'Firstname is required';
        } elseif (strlen($user['firstname']) < 2 || strlen($user['firstname']) > 20) {
            $errors['firstname'] = 'First name must be between 2 and 20 characters long';
        }

        if (empty($user['lastname'])) {
            $errors['lastname'] = 'Last name is required';
        } elseif (strlen($user['lastname']) < 2 || strlen($user['lastname']) > 20) {
            $errors['lastname'] = 'Last name must be between 2 and 20 characters long';
        }


        if (empty($user['email'])) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email is not valid';
        }

        if (empty($user['password'])) {
            $errors['password'] = 'Password is required';
        } elseif (strlen($user['password']) < 6) {
            $errors['password'] = 'Password must be at least 6 characters long';
        }

        return $errors;
    }

    public function show(int $id):string
    {
        $userManager = new UserManager();
        $user = $userManager->selectOneById($id);

        return $this->twig->render('User/show.html.twig', [
            'user' => $user
        ]);
    }
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userManager = new UserManager();
            $userManager->addUser($_POST);
        }
        return $this->twig->render('User/add.html.twig');
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
