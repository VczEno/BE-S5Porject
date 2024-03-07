<?php

require_once('database.php');
require_once('userDTO.php');
$config = require_once('config.php');

use db\DB_PDO;
$PDOConn = DB_PDO::getInstance($config);
$conn = $PDOConn->getConnection();
$userDTO = new UserDTO($conn);
session_start();
print_r($_REQUEST);

if($_REQUEST['action'] === 'login') {

    // Verifico il formato di una email
    $regexemail = '/^((?!\.)[\w\-_.]*[^.])(@\w+)(\.\w+(\.\w+)?[^.\W])$/m';
    preg_match_all($regexemail, htmlspecialchars($_REQUEST['email']), $matchesEmail, PREG_SET_ORDER, 0);
    $email = $matchesEmail ? htmlspecialchars($_REQUEST['email']) : exit('messaggio errore');
    
    // Verifico il formato di una password
    /* $regexPass = '/^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{6,})\S$/';
    preg_match_all($regexPass, htmlspecialchars($_REQUEST['password']), $matchesPass, PREG_SET_ORDER, 0);
    $pass = $matchesPass ? htmlspecialchars($_REQUEST['password']) : exit('passnonvalida');
    $password = password_hash($pass , PASSWORD_DEFAULT); */
    $pass=$_REQUEST['password'];
    

    $res=$userDTO->getUserByEmail($email);
    var_dump($res);

    if($res) {
            
        /* if(password_verify($pass, $res[0]['password'])) { */
        if($pass == $res[0]['password']) {
            
            $_SESSION['userLogin'] = $res[0];

            if(isset($_REQUEST['check'])) {
                setcookie('userEmail', $res[0]['email'], time()+24*60*60*1000);
                setcookie('userPassword', $res[0]['password'], time()+24*60*60*1000);
            }
            echo 'OK!';
            header('location: http://localhost/BackEnd-S5Project/');
        } else {
            echo 'password errati!';
            $_SESSION['error'] = 'password errata!';
           
            header('location: http://localhost/BackEnd-S5Project/login.php'); 
        }
    }else{ 
        echo 'email e password errati!';
        $_SESSION['error'] = 'email e password errati!';
       
       header('location: http://localhost/BackEnd-S5Project/login.php'); 
        
    }


} else if ($_REQUEST['action'] === 'add') {
    echo 'request con action ADD';
    if($userDTO->saveUser(['name' => $_REQUEST['name'], 'lastname' => $_REQUEST['lastname'], 'email' => $_REQUEST['email'], 'password' => $_REQUEST['password']])){
        header('location: http://localhost/BackEnd-S5Project/');
    } else  {
        echo 'error';
    }
}else if ($_REQUEST['action'] === 'delete') {
    echo 'request con action DELETE per l ID ='.$_REQUEST['id'];
    if($userDTO->deleteUser($_REQUEST['id'])) {
        header('location: http://localhost/BackEnd-S5Project/');
    } else  {
        echo 'error';
    }

} else if ($_REQUEST['action'] === 'update') {
    echo 'request con action UPDATE';
    echo $_REQUEST['name'];
    echo $_REQUEST['lastname'];
    $userDTO->updateUser(['name' => $_REQUEST['name'], 'lastname' => $_REQUEST['lastname'], 'email' => $_REQUEST['email'], 'password' => $_REQUEST['password'], 'id' => $_REQUEST['id']]);
    header('location: http://localhost/BackEnd-S5Project/');
}


    




