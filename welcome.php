<?php
require_once 'functions.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial scale=1.0">
    <title>Welcome</title>
    <link href="style.css" rel="stylesheet">

</head>

<body>
    <div class="text-center top-marg">
        <?php
        printSuccessMessage();
        ?>
    </div>
    <h1>Добредојде <?php echo $_SESSION['username']; ?></h1>
</body>

<html>