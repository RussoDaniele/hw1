<?php
  //Creiamo una funzione che controlli la presenza della variabile di sessione
   
  require_once 'dbconfig.php';
  session_start();

  function checkAuth() {
     //Verifico l'accesso e ritorno la sessione
     if(isset($_SESSION['user_id'])){
        return $_SESSION['user_id'];
     }else {
        return 0;
     }
  }
?>