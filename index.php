<?php
require_once('header.php');

/* require_once('database.php');
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
/* $userDTO->deleteUser(6);  



$res = $userDTO->getAll();
 */


if (!isset($_SESSION['userLogin']) && isset($_COOKIE['userEmail']) && isset($_COOKIE['userPassword'])) {
  header('Location: http://localhost/BackEnd-S5Project/controller.php?action=login&email=' . $_COOKIE["userEmail"] . '&password=' . $_COOKIE["userPassword"]);
} else if (!isset($_SESSION['userLogin'])) {
  header('Location: http://localhost/BackEnd-S5Project/login.php');
} /* else if (isset($_SESSION['userLogin'])) {
  echo 'benvenuto ' . $_SESSION['userLogin']['email'];
} else {
  echo 'utente non loggato';
} */



?>
<!-- Button trigger modal -->
<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal_new">
  Aggiungi utente
</button>


<table class="table text-center">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Name </th>
      <th scope="col">Lastname</th>
      <th scope="col">Email</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    <?php

    if ($res) { // Controllo se ci sono dei dati nella variabile $res
      foreach ($res as $row) {

        ?>
        <tr>
          <th scope="row">
            <?= $row['id'] ?>
          </th>
          <td>
            <?= $row['name'] ?>
          </td>
          <td>
            <?= $row['lastname'] ?>
          </td>
          <td>
            <?= $row['email'] ?>
          </td>
          
          <td class='d-flex justify-content-evenly'>
            <!-- <form method='post' action="controller.php?action=update&id=<?= $row['id'] ?>" > -->
            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
              data-bs-target="#exampleModal_<?= $row['id'] ?>">Modifica</button>
            <!-- </form> -->

            <form method='post' action="controller.php?action=delete&id=<?= $row['id'] ?>">
              <button type="submit" class="btn btn-danger">Elimina</button>
            </form>
          </td>
        </tr>
        <?php
          require('updateusermodal.php');
      }
    }
    ;
    ?>

  </tbody>
</table>
<?php
          if(isset($_SESSION['CRUDerror'])) {
            echo '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
            <strong>'.$_SESSION['CRUDerror'].'
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
          }
        ?>









<?php
require_once('createusermodal.php');

if(isset($_SESSION['CRUDerror'])){
  unset($_SESSION['CRUDerror']);
}
      
include_once('footer.php');