<?php
   require_once 'checkAuth.php';
   if (!$userid = checkAuth()) exit;

   savemovie();

   function savemovie(){
    global $dbconfig, $userid;

    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

    $userid = mysqli_real_escape_string($conn, $userid);
    $image = mysqli_real_escape_string($conn, $_POST['image']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $genre = mysqli_real_escape_string($conn, $_POST['genre']);
    $runtime = mysqli_real_escape_string($conn, $_POST['runtime']);
    $cast = mysqli_real_escape_string($conn, $_POST['cast']);
    $plot = mysqli_real_escape_string($conn, $_POST['plot']);

    $query = "SELECT * FROM savedmovies WHERE user = '$userid' AND title = '$title'";
    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
    if(mysqli_num_rows($res) > 0) {
        echo json_encode(array('ok' => true));
         exit;
    }

    $query = "INSERT INTO savedmovies(user, image, title, genre, runtime, cast, plot) VALUES('$userid', '$image', '$title', '$genre', '$runtime', '$cast', '$plot')";
    if(mysqli_query($conn, $query) or die(mysqli_error($conn))) {
        echo json_encode(array('ok' => true));
        exit;
    }

    mysqli_close($conn);
    echo json_encode(array('ok' => false));
   }
?>