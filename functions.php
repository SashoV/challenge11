<?php

function checkRegisterFields()
{
    if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password'])) {
        header("Location: register.php?danger=required");
        die();
    }
}


function checkLoginFields()
{
    if (empty($_POST['username']) || empty(strtolower($_POST['email'])) || empty($_POST['password'])) {
        header("Location: login.php?danger=required");
        die();
    }
}


function isUsernameValid()
{
    if (!preg_match("/^[a-zA-Z0-9]+$/", $_POST['username'])) {
        header("Location: register.php?danger=notvalidusername");
        die();
    }
}


function isEmailValid()
{
    if (!preg_match("/^(?=[^@]{5,}@)([\w\.-]*[a-zA-Z0-9_]@(?=.{4,}\.[^.]*$)[\w\.-]*[a-zA-Z0-9]\.[a-zA-Z][a-zA-Z\.]*[a-zA-Z])$/", strtolower($_POST['email']))) {
        header("Location: register.php?danger=notvalidemail");
        die();
    }
}


function isPasswordValid()
{
    if (!preg_match("/(?=.*?[0-9])(?=.*[A-Z])(?=.*[!\{\}@;:<>~`\\.,'\"#\$%\^&\+\_\-\/\|\[\]\=?()\*\s])/", $_POST['password'])) {
        header("Location: register.php?danger=notvalidpassword");
        die();
    }
}

function isUsernameTaken() {

    $allusers = file_get_contents("users.txt");
    $allusers = explode("\n", $allusers);
    foreach ($allusers as $user) {
        $user = preg_split('/[,=]/', $user, 3);
        if ($user[1] == $_POST['username']) {
            $_SESSION['password'] = $user[2];
            header("Location: register.php?info=usernametaken");
            die();
        }
    }
}


function isEmailTaken() {
    $allusers = file_get_contents("users.txt");
    $allusers = explode("\n", $allusers);

    foreach ($allusers as $user) {
        $user = preg_split('/[,=]/', $user, 3);
        if ($user[0] == strtolower($_POST['email'])) {
            $_SESSION['password'] = $user[2];
            header("Location: register.php?info=emailfound");
            die();
        }
    }
}

function loginUser() {
    $allusers = file_get_contents("users.txt");
    $allusers = explode("\n", $allusers);
    
    foreach ($allusers as $user) {
        $user = preg_split('/[,=]/', $user, 3);
        if ($user[0] == strtolower($_POST['email']) && $user[1] == $_POST['username'] && $user[2] == $_POST['password']) {
            $_SESSION['username'] = $_POST['username'];
            header("Location: welcome.php?success=loggedin");
            die();
        }
    }
    header("Location: login.php?danger=usernotfound");
    die();
}


function registerUser() {
    if (file_put_contents("users.txt", strtolower($_POST['email']) . "," . $_POST['username'] . "=" . $_POST['password'] . "\n", FILE_APPEND)) {
        $_SESSION['username'] = $_POST['username'];
        header("Location: welcome.php?success=register");
        die();
    } else {
        header("Location: register.php?danger=general");
        die();
    }
}


function printErrorMessage()
{
    if (isset($_GET['danger'])) {
        $dangerMessages = [
            'notvalidusername' => "Корисничкото
            име не ги задоволува сите побарувања.",
            'notvalidemail' => "Имејлот не ги задоволува сите побарувања",
            'notvalidpassword' => "Пасвордот не ги задоволува сите побарувања.",
            'required' => "Сите полиња се задолжителни.",
            'usernametaken' => "Веќе постои
            корисник со тоа корисничко име.",
            'usernotfound' => "Не е пронајден корисник со таа комбинација на податоци.",
            'emailfound' => "Веќе се имате
            регистрирано, вашиот пасворд е пасвордотЗаТојКорисник.",
            'general' => "Се појави грешка, обидете се подоцна."
        ];

        if (isset($dangerMessages[$_GET['danger']])) {
            echo "<span class='red-alert'>" . $dangerMessages[$_GET['danger']] . "</span><br><a href = 'index.php' class = 'btn'>назад кон почетна</a>";
        }
    }
}


function printInfoMessage()
{
    if (isset($_GET['info'])) {
        $infoMessages = [
            'required' => "Сите полиња се задолжителни.",
            'usernametaken' => "Веќе постои
            корисник со тоа корисничко име.",
            'usernotfound' => "Не е пронајден корисник со таа комбинација на податоци.",
            'emailfound' => "Веќе се имате
            регистрирано, вашиот пасворд е {$_SESSION['password']}."
        ];

        if (isset($infoMessages[$_GET['info']])) {
            echo "<span class='yellow'>" . $infoMessages[$_GET['info']] . "</span><br><a href = 'index.php' class = 'btn'>назад кон почетна</a>";
        }
    }
}


function printSuccessMessage()
{
    if (isset($_GET['success'])) {
        $successMessages = [
            'loggedin' => "Успешно се логиравте.",
            'register' => "Успешно се регистриравте."
        ];

        if (isset($successMessages[$_GET['success']])) {
            echo "<span class='green'>" . $successMessages[$_GET['success']] . "</span>";
        }
    }
}
