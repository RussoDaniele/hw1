<?php
require_once 'dbconfig.php';

if (!isset($_GET["q"])){
    echo "Errore: Accesso non legittimo";
    exit;
}

$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

$email = mysqli_real_escape_string($conn, $_GET["q"]);

$query = "SELECT email FROM users WHERE email = '$email'";

$res = mysqli_query($conn, $query) or die(mysqli_error($conn));

header('Content-Type: application/json');
echo json_encode(array('exists' => mysqli_num_rows($res) > 0 ? true : false));

mysqli_close($conn);
?>