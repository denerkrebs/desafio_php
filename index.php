<?php

$con_string = "host=127.0.0.1 port=5432 dbname=desafio_php user=postgres password=root";
$connection = pg_connect($con_string);

if($connection){
    echo "Conectado";
}