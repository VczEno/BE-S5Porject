<?php

include_once('header.php');

?>
<form method='post' action='controller.php?action=login' class=' mt-5 p-5  w-50 mx-auto rounded-4 shadow bg-light'>
<div class="mb-3">
    <label for="inputMail">Mail</label>
    <input type="email" class="form-control" id="inputMil" aria-describedby="emailHelp" name='email'>
</div>
<div class="mb-3">
    <label for="inputPass">Password</label>
    <input type="password" class="form-control" id="inputPass" name='password'>
</div>
<div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1" name='check'>
            <label class="form-check-label" for="exampleCheck1">Spunta per mantenere l'accesso</label>
</div>

<button type="submit" class="btn btn-primary">Login</button>
</form>

<?php
if(count($res) === 1 && $userDTO->getUserByEmail('admin@mail.com')  ) { // se l'array è vuoto crea un utente admin per il primo login
  echo '<div class="alert alert-success my-3 text-center">credenziali per il primo accesso: <strong>email: admin@mail.com password: Pa$$w0rd</strong></div>';

}
  if(isset($_SESSION['loginerror'])) {
    echo '<div class="alert alert-danger my-3" role="alert">'.$_SESSION['loginerror'].'</div>';
  }
  



include_once('footer.php');