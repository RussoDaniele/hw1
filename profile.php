<?php
  require_once 'checkAuth.php';
  if (!$userid = checkAuth()){
    header("Location: login.php");
    exit;
  }
?>

<html>
  <?php 
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
        $userid = mysqli_real_escape_string($conn, $userid);
        $query = "SELECT * FROM users WHERE id = $userid";
        $res = mysqli_query($conn, $query);
        $userinfo = mysqli_fetch_assoc($res);   
   ?>
  <head>
     <title>Cinemania - <?php echo $userinfo['username']?></title>
  
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-widht, initial-scale=1">
     
     <link href="https://fonts.googleapis.com/css?family=Open+Sans|Nunito" rel="stylesheet">
     <link rel="icon" type="image/png" href="logoC.png">
     <link rel='stylesheet' href='profile.css'>
     <script src="profile.js" defer="true"></script>
  </head>

  <body>
    <header id="index">
        <div id="overlay"></div>
        <nav>
           <div id="logo">
             <div><img src="./assets/logoC.png"/></div>
             <h1>Cinemania</h1>
           </div>
           <div id="links">
            <a href='home.php'>HOME</a>
            <a>DISCOVER</a>
            <a>ABOUT</a>
            <div id="separator"></div>
            <a href='logout.php' class='button'>ESCI</a>
           </div>
        </nav>
        <h1><?php echo $userinfo['username']?></h1>
        <p>Ecco l'elenco dei film che vorresti guardare</p> 
    </header>
    <section id="res-container">

        
    </section>
    <footer id="end">
      <p> Developed by Russo Daniele 1000014831</p>
    </footer>
  </body>
</html>

<?php mysqli_close($conn); ?>