<?php
    session_start(); // leggo una sessione esistente
    session_destroy(); // distruggo una sessione esistente
    setcookie("userEmail", "", time()-3600); // distruggo un cookie esistente
    setcookie("userPassword", "", time()-3600); // distruggo un cookie esistente
    header('Location: http://localhost/BackEnd-S5Project/login.php');