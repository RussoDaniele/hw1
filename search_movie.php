<?php
require_once 'checkAuth.php';

if (!checkAuth()) exit;

header('Content-Type: application/json');

omdb();

function omdb(){
    $search = urlencode($_GET["q"]);

    $key = "7d3e470c";
    $data = http_build_query(array("apikey" => $key, "t" => $search));
    $url = 'http://www.omdbapi.com/?'.$data;

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $res = curl_exec($curl);
    curl_close($curl);

    echo $res;
}
?>