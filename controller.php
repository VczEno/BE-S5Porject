<?php
session_start();
require_once('database.php');
require_once('userDTO.php');
$config = require_once('config.php');

use db\DB_PDO;
$PDOConn = DB_PDO::getInstance($config);
$conn = $PDOConn->getConnection();
$userDTO = new UserDTO($conn);
print_r($_REQUEST);
if(isset($_SESSION['CRUDerror'])){
    unset($_SESSION['CRUDerror']);
}

if(isset($_REQUEST['name'])) {
    $name = strlen(trim(htmlspecialchars(strip_tags($_REQUEST['name'])))) > 2 ? trim(htmlspecialchars(strip_tags($_REQUEST['name']))) : exit('nome troppo corto');
    echo $_REQUEST['name'];
    echo $name;
}
if(isset($_REQUEST['lastname'])) {
    $lastname = strlen(trim(htmlspecialchars(strip_tags($_REQUEST['lastname'])))) > 2 ? trim(htmlspecialchars(strip_tags($_REQUEST['lastname']))) : exit('cognome troppo corto');
}


if(isset($_REQUEST['email'])) {
    $regexemail = '/^((?!\.)[\w\-_.]*[^.])(@\w+)(\.\w+(\.\w+)?[^.\W])$/m';
    preg_match_all($regexemail, htmlspecialchars(strip_tags($_REQUEST['email'])), $matchesEmail, PREG_SET_ORDER, 0);
    $email = $matchesEmail ? htmlspecialchars(strip_tags($_REQUEST['email'])) : exit('mail non valida');
};

if(isset($_REQUEST['password'])) {
    $regexPass = '/^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{6,})\S$/';
    preg_match_all($regexPass, htmlspecialchars(strip_tags($_REQUEST['password'])), $matchesPass, PREG_SET_ORDER, 0);
    $pass = $matchesPass ? htmlspecialchars(strip_tags($_REQUEST['password'])) : exit('passnonvalida');
    $password = password_hash($pass , PASSWORD_DEFAULT);
    $pass=$_REQUEST['password'];
};

if($_REQUEST['action'] === 'login') {

    // Verifico il formato di una email
    /* $regexemail = '/^((?!\.)[\w\-_.]*[^.])(@\w+)(\.\w+(\.\w+)?[^.\W])$/m';
    preg_match_all($regexemail, htmlspecialchars($_REQUEST['email']), $matchesEmail, PREG_SET_ORDER, 0);
    $email = $matchesEmail ? htmlspecialchars($_REQUEST['email']) : exit('messaggio errore');
     */
    // Verifico il formato di una password
/*     $regexPass = '/^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{6,})\S$/';
    preg_match_all($regexPass, htmlspecialchars($_REQUEST['password']), $matchesPass, PREG_SET_ORDER, 0);
    $pass = $matchesPass ? htmlspecialchars($_REQUEST['password']) : exit('passnonvalida');
    $password = password_hash($pass , PASSWORD_DEFAULT);
    $pass=$_REQUEST['password']; */
    

    $res=$userDTO->getUserByEmail($email);
    var_dump($res);

    if($res) {
            
        if(password_verify($pass, $res[0]['password'])) { 
        /* if($pass == $res[0]['password']) { */
            
            $_SESSION['userLogin'] = $res[0];

            if(isset($_REQUEST['check'])) {
                setcookie('userEmail', $res[0]['email'], time()+60*60*24*30);
                setcookie('userPassword', $res[0]['password'], time()+60*60*24*30);
            }
            echo 'OK!';
            header('location: http://localhost/BackEnd-S5Project/');
        } else {
            echo 'password errati!';
            $_SESSION['loginerror'] = 'password errata!';
           
            header('location: http://localhost/BackEnd-S5Project/login.php'); 
        }
    }else{ 
        echo 'email e password errati!';
        $_SESSION['loginerror'] = 'email e password errati!';
       
       header('location: http://localhost/BackEnd-S5Project/login.php'); 
        
    }


} else if ($_REQUEST['action'] === 'add') {
    if(!$userDTO->saveUser(['name' => $name, 
                            'lastname' => $lastname, 
                            'email' => $email, 
                            'password' => $password])) {
        $_SESSION['CRUDerror'] = "c'è stato un errore nella creazione di un nuovo utente, ti invitiamo a riprovare più tardi";
    }    
    header('location: http://localhost/BackEnd-S5Project/');
    
}else if ($_REQUEST['action'] === 'delete') {
    if($_SESSION['userLogin']['id'] == $_REQUEST['id']) {
        
        $_SESSION['CRUDerror'] = "non puoi eliminare l'utente con cui sei loggato";
    } else {
        if(!$userDTO->deleteUser($_REQUEST['id'])) { //per provare la gestione dell'errore dare come parametro un id che non esiste
            $_SESSION['CRUDerror'] = "c'è stato un errore nell'eliminazione dell'utente, ti invitiamo a riprovare più tardi";
        }
    } 
    
     header('location: http://localhost/BackEnd-S5Project/');

} else if ($_REQUEST['action'] === 'update') {
    if(!$userDTO->updateUser(['name' => $name, 
                                'lastname' => $lastname, 
                                'email' => $email, 
                                'password' => $password, 
                                'id' => $_REQUEST['id']])) {
        $_SESSION['CRUDerror'] = "c'è stato un errore nella modifica dell'utente, ti invitiamo a riprovare più tardi";
    }
    /* header('location: http://localhost/BackEnd-S5Project/'); */
}


    




