<?php
session_start();


require_once('database.php');
require_once('userDTO.php');
$config = require_once('config.php');




use db\DB_PDO;

$PDOConn = DB_PDO::getInstance($config);
$conn = $PDOConn->getConnection();
$conn->exec('CREATE TABLE IF NOT EXISTS users (
  id TINYINT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  lastname VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE, 
  password VARCHAR(255) NOT NULL)');
$userDTO = new UserDTO($conn);


 /* $userDTO->updateUser(['name' => 'Pippo', 'lastname' => 'Matto', 'email' => 'pippomatto@mail.com', 'password' => 'chiave', 'id' => 6]); */
/* $userDTO->deleteUser(6);  */



$res = $userDTO->getAll();

if(count($res) === 0 ) { // se l'array è vuoto crea un utente admin per il primo login
    /* $userDTO->saveUser(['name' => 'admin', 'lastname' => 'admin', 'email' => 'admin@mail.com', 'password' => 'admin']); */
    header('location: http://localhost/BackEnd-S5Project/controller.php?action=add&name=admin&lastname=admin&email=admin@mail.com&password=Pa$$w0rd');
    $res = $userDTO->getAll();
  }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S5Project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">S5-Project</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                    aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                        </li>

                    </ul>
                   <!--  <span class="navbar-text me-5">
                        <a class="nav-link active" aria-current="page" href="login.php">Login</a>
                    </span> -->
                    <span class="navbar-text me-3">
                        <?php
                            if (isset($_SESSION['userLogin'])) {
                            echo 'bentornato <strong>' . $_SESSION['userLogin']['name'].' '.$_SESSION['userLogin']['lastname'].'</strong>';
                        } ?>
                    </span>
                    <span class="navbar-text px-3 border-start border-dark">
                        <a class="nav-link active" aria-current="page" href="logout.php">Logout</a>
                    </span>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <div class="container">

