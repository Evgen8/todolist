<?php
namespace controller;

use core\Application;
use core\Controller;
use model\User;

class SiteController extends Controller
{
    protected function actionIndex()
    {
        echo "<h1>Home page</h1>";
    }

    protected function actionLogin()
    {
        /**
         * @todo: Move to View class
         */
        if(!Application::getSession()->isLoginned()) {
            ?>
            <h1>Login page</h1>
            <form action="" method="post">
                Login:
                <input type="text" name="username"/>
                <br>
                Password:
                <input type="password" name="password"/>
                <br>
                <input type="submit">
            </form>

            <?php
            if (!empty($_POST)) {
                if (!empty($_POST['username']) && !empty($_POST['password'])) {
                    $name = htmlspecialchars($_POST['username']);
                    $password = $_POST['password'];
                    $user = User::findOne('name = :name', [':name' => $name]);

                    var_dump($user);
                    if (password_verify($password, $user->password)) {
                        var_dump(Application::getSession()->isLoginned());
                        if (!Application::getSession()->isLoginned()) {
                            var_dump(Application::getSession()->login($user));
                            var_dump(Application::getSession()->isLoginned());
                        }
                        var_dump($_SESSION);
                    } else {
                        echo '<p>Incorrect password</p>';
                    }
                } else {
                    echo 'Please fill all fields';
                }
            }
        } else {
            echo 'You are logged in as '.$_SESSION['session_name'];
            //var_dump(Application::getSession()->isLoginned());
            //var_dump($_SESSION);
        }
    }

    protected function actionRegister()
    {


        ?>
        <h3>Registration form</h3>
        <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
            Your name:
            <input type="text" name="name" />
            <br>
            Your email:
            <input type="email" name="email" />
            <br>
            Password:
            <input type="password" name="password" />
            <br>
            <input type="submit">
        </form>

        <?php

        if(!empty($_POST)) {
            if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['password']) ) {

                $newUser = new User([
                    'name' => htmlspecialchars($_POST['name']),
                    'email' => htmlspecialchars($_POST['email']),
                    'password' => password_hash($_POST['password'],PASSWORD_BCRYPT),
                ]);

                if($newUser->save()) {
                    echo '<p>You successfully registered</p>
                            <a href="/login">Log in</a>';
                } else {
                    echo 'An error has occurred';
                }
            } else {
                echo 'Please fill all fields';
            }
        }
    }
}