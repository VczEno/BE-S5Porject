<?php
include_once('header.php');

require_once('database.php');
require_once('userDTO.php');
$config = require_once('config.php');
session_start();

if(!isset($_SESSION['userLogin']) && isset($_COOKIE['userEmail']) && isset($_COOKIE['userPassword']) ) {
    header('Location: http://localhost/BackEnd-S5Project/controller.php?email='.$_COOKIE["userEmail"].'&password='.$_COOKIE["userPassword"]);
} else if (!isset($_SESSION['userLogin'])) {
    header('Location: http://localhost/BackEnd-S5Project/login.php');
}else if (isset($_SESSION['userLogin'])) {
    echo 'benvenuto '.$_SESSION['userLogin']['email'];
}  else {
    echo 'utente non loggato';
}

use db\DB_PDO;
$PDOConn = DB_PDO::getInstance($config);
$conn = $PDOConn->getConnection();
$userDTO = new UserDTO($conn);

/* $userDTO->saveUser(['name' => 'Pippo', 'lastname' => 'inzaghi', 'email' => 'pippoinz@mail.com', 'password' => 'password']); */
/* $userDTO->updateUser(['name' => 'Pippo', 'lastname' => 'Matto', 'email' => 'pippomatto@mail.com', 'password' => 'chiave', 'id' => 6]); */
/* $userDTO->deleteUser(6);  */
$peppe = $userDTO->getUserByEmail('mario.r@example.com');


$res = $userDTO->getAll();


?>

<table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Name </th>
      <th scope="col">Lastname</th>
      <th scope="col">Email</th>
      <th scope="col">Password</th>
    </tr>
  </thead>
  <tbody>
    <?php

  if($res) { // Controllo se ci sono dei dati nella variabile $res
    foreach($res as $row) {
        
    ?>
        <tr>
        <th scope="row"><?=$row['id'] ?></th>
        <td><?=$row['name'] ?></td>
        <td><?=$row['lastname'] ?></td>
        <td><?=$row['email'] ?></td>
        <td><?=$row['password'] ?></td>
        </tr>
    <?php
    }
};
?>
  
  </tbody>
</table>



<?php

include_once('footer.php');