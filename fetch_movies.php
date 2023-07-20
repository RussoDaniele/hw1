<?php
  require_once 'checkAuth.php';
  if (!$userid = checkAuth()) exit;

  header('Content-Type: application/json');

  $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

  $userid = mysqli_real_escape_string($conn, $userid);

  $query = "SELECT * FROM savedmovies where user = $userid";

  $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

  $movieArray = array();
  while($entry = mysqli_fetch_assoc($res)) {
    $movieArray = array('user' => $entry['user'], 'id' => $entry['id'], 'image' => $entry['image'], 
    'title' => $entry['title'], 'genre' => $entry['genre'], 'runtime' => $entry['runtime'],
    'cast' => $entry['cast'], 'plot' => $entry['plot']);
  }
  echo json_encode($movieArray);

  exit;
?>