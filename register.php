<?php
require_once 'functions.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    
    checkRegisterFields();

    isUsernameValid();

    isEmailValid();

    isPasswordValid();

    isUsernameTaken();
    
    isEmailTaken();
    
    registerUser();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial scale=1.0">
    <title>Регистрација</title>
    <link href="style.css" rel="stylesheet">

</head>

<body>
    <h1>Регистрирај се</h1>
    <form method="POST" action="">
        <label for="username">Корисничко Име</label>
        <input type="text" name="username" id="username">
        <br />
        <label for="email">Имејл</label>
        <input type="text" name="email" id="email">
        <br />
        <label for="psw">Пасворд</label>
        <input type="password" name="password" id="psw">
        <br />
        <button class="btn">Регистрирај се</button>
    </form>
    <div class="msg">
        <?php
        printErrorMessage();
        printInfoMessage();
        ?>
    </div>
</body>

<html>