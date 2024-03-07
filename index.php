<?php
include_once('header.php');

require_once('database.php');
require_once('userDTO.php');
$config = require_once('config.php');
session_start();

if (!isset($_SESSION['userLogin']) && isset($_COOKIE['userEmail']) && isset($_COOKIE['userPassword'])) {
  header('Location: http://localhost/BackEnd-S5Project/controller.php?email=' . $_COOKIE["userEmail"] . '&password=' . $_COOKIE["userPassword"]);
} else if (!isset($_SESSION['userLogin'])) {
  header('Location: http://localhost/BackEnd-S5Project/login.php');
} else if (isset($_SESSION['userLogin'])) {
  echo 'benvenuto ' . $_SESSION['userLogin']['email'];
} else {
  echo 'utente non loggato';
}

use db\DB_PDO;

$PDOConn = DB_PDO::getInstance($config);
$conn = $PDOConn->getConnection();
$userDTO = new UserDTO($conn);

/* $userDTO->saveUser(['name' => 'Ennio', 'lastname' => 'Annio', 'email' => 'Ennio@mail.com', 'password' => 'password']);
 *//* $userDTO->updateUser(['name' => 'Pippo', 'lastname' => 'Matto', 'email' => 'pippomatto@mail.com', 'password' => 'chiave', 'id' => 6]); */
/* $userDTO->deleteUser(6);  */
$peppe = $userDTO->getUserByEmail('mario.r@example.com');


$res = $userDTO->getAll();


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
      <th scope="col">Password</th>
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
          <td>
            <?= $row['password'] ?>
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

        <div class="modal fade" id="exampleModal_<?= $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
          aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form method='post' action="controller.php?action=update&id=<?= $row['id'] ?>">
                  <div class="mb-3">
                    <label for="inputName">Name</label>
                    <input type="text" class="form-control" id="inputName" aria-describedby="emailHelp" name='name'
                      placeholder='<?= $row['name'] ?>' value='<?= $row['name'] ?>'>
                  </div>
                  <div class="mb-3">
                    <label for="inputLastName">Lastname</label>
                    <input type="text" class="form-control" id="inputLastname" aria-describedby="emailHelp" name='lastname'
                      placeholder='<?= $row['lastname'] ?>' value='<?= $row['lastname'] ?>'>
                  </div>
                  <div class="mb-3">
                    <label for="inputMail">Mail</label>
                    <input type="email" class="form-control" id="inputMail" aria-describedby="emailHelp" name='email'
                      placeholder='<?= $row['email'] ?>' value='<?= $row['email'] ?>'>
                  </div>
                  <div class="mb-3">
                    <label for="inputPass">Password</label>
                    <input type="password" class="form-control" id="inputPass" name='password'
                      placeholder='<?= $row['password'] ?>' value='<?= $row['password'] ?>'>
                  </div>


              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
              </form>

            </div>
          </div>
        </div>
        <?php
      }
    }
    ;
    ?>

  </tbody>
</table>




<!-- Modal New User -->
<div class="modal fade" id="exampleModal_new" tabindex="-1" aria-labelledby="exampleModalLabel"
          aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form method='post' action="controller.php?action=add">
                  <div class="mb-3">
                    <label for="inputName">Name</label>
                    <input type="text" class="form-control" id="inputName" aria-describedby="emailHelp" name='name'>
                  </div>
                  <div class="mb-3">
                    <label for="inputLastName">Lastname</label>
                    <input type="text" class="form-control" id="inputLastname" aria-describedby="emailHelp" name='lastname'>
                  </div>
                  <div class="mb-3">
                    <label for="inputMail">Mail</label>
                    <input type="email" class="form-control" id="inputMail" aria-describedby="emailHelp" name='email'>
                  </div>
                  <div class="mb-3">
                    <label for="inputPass">Password</label>
                    <input type="password" class="form-control" id="inputPass" name='password'>
                  </div>


              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
              </form>

            </div>
          </div>
        </div>




<?php

include_once('footer.php');