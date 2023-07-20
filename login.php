<?php
   require_once 'checkAuth.php';

   //Se è presente la sessione rimanda alla home
   if (checkAuth()){
     header("Location : home.php");
     exit;
   }

   if(!empty($_POST["username"]) && !empty($_POST["password"])){
      
      $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

      $username = mysqli_real_escape_string($conn, $_POST['username']);

      $query = "SELECT * FROM users WHERE username = '$username'";

      $res = mysqli_query($conn, $query) or die(mysqli_error($conn));;
        
      if (mysqli_num_rows($res) > 0) {
            $dbres = mysqli_fetch_assoc($res);
            if (password_verify($_POST['password'], $dbres['password'])) {

                $_SESSION["user_username"] = $dbres['username'];
                $_SESSION["user_id"] = $dbres['id'];
                header("Location: home.php");
                mysqli_free_result($res);
                mysqli_close($conn);
                exit;
            }
      }
     $error = "Username e/o password errati.";
    } else if (isset($_POST["username"]) || isset($_POST["password"])) {
        $error = "Inserisci username e password.";
    }
?>

<html>
    <head>
        <title>Accedi - Cinemania</title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel='stylesheet' href='login.css'>

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
            <h5>Esegui l'accesso per continuare a navigare su Cinemania.</h5>
            <form name='login' method='post'>
                <div class="username">
                    <label for='username'>Username</label>
                    <input type='text' name='username' <?php if(isset($_POST["username"])){echo "value=".$_POST["username"];} ?>>
                </div>
                <div class="password">
                    <label for='password'>Password</label>
                    <input type='password' name='password' <?php if(isset($_POST["password"])){echo "value=".$_POST["password"];} ?>>
                </div>
                <div class="btn-container">
                    <div class="login-btn">
                        <input type='submit' value="ACCEDI">
                    </div>
                </div>
            </form>
            <?php
                // Verifica la presenza di errori
                if (isset($error)) {
                    echo "<p class='errorp'>$error</p>";
                }
                
            ?>
            <div><h4>Non hai un account?</h4></div>
            <div class="btn-container">
             <div id="signup"><a class="signup-btn" href="signup.php">ISCRIVITI A CINEMANIA</a></div>
            </div>
        </section>
        </main>
    </body>
</html>