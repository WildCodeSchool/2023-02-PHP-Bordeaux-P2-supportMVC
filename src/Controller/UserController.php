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

    public function show($id)
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

    public function edit()
    {
        echo 'Hello from edit from usercontroller';
    }

    public function delete()
    {
        echo 'Hello from delete from usercontroller';
    }
}
