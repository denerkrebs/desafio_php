<?php

require __DIR__ . '/config/db.php';
require __DIR__ . '/objetos/produto.php';

if($_POST){
    $database = new Database();
    $db = $database->getConnection();
     
    $produto = new Produto($db);
    $produto->produto_id = $_POST['object_id'];
     
    if($produto->delete()){
        echo "Objeto foi excluido";
    }
    else{
        echo "Não foi possivel excluir";
    }
}
