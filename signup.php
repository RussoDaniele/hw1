<?php
   require_once 'checkAuth.php';

   //Se è presente la sessione rimanda alla home
   if (checkAuth()){
     header("Location : home.php");
     exit;
   }

   //Verifica esistenza dati POST
   if (!empty($_POST["password"]) && !empty($_POST["confirm_password"]) && 
        !empty($_POST["username"]) && !empty($_POST["email"]))
    {
      $error = array();
      $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'],$dbconfig['password'],$dbconfig['name']) or die(mysqli_error($conn));
     
    //Verifico se l'username rispetta il pattern
    if(!preg_match('/^[a-zA-Z0-9_]{1,15}$/', $_POST['username'])) {
        $error[] = "Username non valido, sono ammessi solo: caratteri minuscoli e maiuscoli, numeri e underscore. Max: 15";
    } else {
      $username = mysqli_real_escape_string($conn, $_POST['username']);
            // Cerco se l'username esiste già
            $query = "SELECT username FROM users WHERE username = '$username'";
            $res = mysqli_query($conn, $query);
            if (mysqli_num_rows($res) > 0) {
                $error[] = "Username già in uso";
            }
    }
 
    if (strlen($_POST["password"]) < 8) {
      $error[] = "Caratteri password insufficienti: almeno 8 caratteri";
    } 
  
    if (strcmp($_POST["password"], $_POST["confirm_password"]) != 0) {
      $error[] = "Le password non coincidono";
    }

    
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      $error[] = "Inserire una email valida";
    } else {
      $email = mysqli_real_escape_string($conn, strtolower($_POST['email'])); //strtolower rende tutta la stringa in minuscolo
      $res = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
      if (mysqli_num_rows($res) > 0) {
          $error[] = "Email già in uso";
      }
    }
 
    if(count($error) == 0) {
      $password = mysqli_real_escape_string($conn, $_POST["password"]);
      $password = password_hash($password, PASSWORD_BCRYPT);

      $query = "INSERT INTO users(username, password, email, propic) VALUES('$username', '$password', '$email', '$propic')";

      if (mysqli_query($conn, $query)) {
        $_SESSION["user_username"] = $_POST["username"];
        $_SESSION["user_id"] = mysqli_insert_id($conn);
        mysqli_close($conn);
        header("Location: home.php");
        exit;
      } else {
        $error[] = "Errore di connessione al Database";
      }
    }
    mysqli_close($conn);

  } else if (isset($_POST["username"]) || isset($_POST["password"]) || isset($_POST["confirm_password"]) || isset($_POST["email"])){
      $error= array("Riempi tutti i campi");
  }
?>

<html>
  <head>
     <title>Iscriviti - Cinemania</title>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">

     <link rel='stylesheet' href='signup.css'>
     <script src='signup.js' defer></script>
  
     <link href="https://fonts.googleapis.com/css?family=Open+Sans|Nunito" rel="stylesheet">
     <link rel="icon" type="image/png" href="logoC.png">
  </head>

  <body class="container">
   <div id="overlay"></div>
   <main class="container">
    <section id="left">
    <div id="overlay"></div>
    
    <div id="logo">
     <div><img src="./assets/logoC.png"/></div>
     <h1>Cinemania</h1>
    </div>
    </section>

    <section id="right">
            <form name='signup' method='post' enctype="multipart/form-data" autocomplete="off">
                <div class="username">
                    <label for='username'>Nome utente</label>
                    <input type='text' name='username' <?php if(isset($_POST["username"])){echo "value=".$_POST["username"];} ?>>
                    <div><img src="./assets/xerr.png"/><span>Nome utente non disponibile</span></div>
                </div>
                <div class="email">
                    <label for='email'>Email</label>
                    <input type='text' name='email' <?php if(isset($_POST["email"])){echo "value=".$_POST["email"];} ?>>
                    <div><img src="./assets/xerr.png"/><span>Indirizzo email non valido</span></div>
                </div>
                <div class="password">
                    <label for='password'>Password</label>
                    <input type='password' name='password' <?php if(isset($_POST["password"])){echo "value=".$_POST["password"];} ?>>
                    <div><img src="./assets/xerr.png"/><span>Inserisci almeno 8 caratteri</span></div>
                </div>
                <div class="confirm_password">
                    <label for='confirm_password'>Conferma Password</label>
                    <input type='password' name='confirm_password' <?php if(isset($_POST["confirm_password"])){echo "value=".$_POST["confirm_password"];} ?>>
                    <div><img src="./assets/xerr.png"/><span>Le password non coincidono</span></div>
                </div>
                <?php if(isset($error)) {
                    foreach($error as $err) {
                        echo "<div class='errorp'><img src='./assets/xerr.png'/><span>".$err."</span></div>";
                    }
                } ?>
                <div class="submit">
                    <input type='submit' value="Registrati" id="submit">
                </div>
            </form>
            <div class="signup">Possiedi già un account? <a href="login.php">Accedi</a>
    </section>
   </main>
  </body>
</html>