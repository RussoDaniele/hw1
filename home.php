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
     <title>Cinemania</title>
  
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-widht, initial-scale=1">
     
     <link href="https://fonts.googleapis.com/css?family=Open+Sans|Nunito" rel="stylesheet">
     <link rel="icon" type="image/png" href="logoC.png">
     <link rel='stylesheet' href='home.css'>
     <script src="home.js" defer="true"></script>
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
            <a>HOME</a>
            <a>DISCOVER</a>
            <a>ABOUT</a>
            <div id="separator"></div>
            <a href='profile.php'>PROFILO</a>
            <a href='logout.php' class='button'>ESCI</a>
           </div>
        </nav>
        <h1>Benvenuto <?php echo $userinfo['username']?></h1>
        <p>Naviga nel mondo del Cinema</p>
        <div id="search">
         <form autocomplete="off">
          <div class="container">
           <div class="search"><label for='search'></label><input type='text' name="search" class="searchbar"></div>
           <div><input type="submit" value="Cerca" class="sbutton"></div>
          </div>
         </form>
        </div>
    </header>
    <section id="res-container">

        
    </section>
    <footer id="end">
      <p> Developed by Russo Daniele 1000014831</p>
    </footer>
  </body>
</html>

<?php mysqli_close($conn); ?>