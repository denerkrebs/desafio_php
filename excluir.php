<?php
session_start();

require __DIR__ . '/config/db.php';
require __DIR__ . '/objetos/produto.php';
require __DIR__ . '/objetos/tipo_produto.php';

if($_POST){
    $database = new Database();
    $db = $database->getConnection();
    
    $page = $_POST['object_page'];
    $id = $_POST['object_id'];

    if($page == "produto"){
        $produto = new Produto($db);
        $produto->produto_id = $id;
        $return = $produto->delete();
    } else if($page == "tipo-produto") {
        $tipoProduto = new TipoProduto($db);
        $tipoProduto->tipo_produto_id = $id;
        $return = $tipoProduto->delete();
    } else if($page == "venda") {
        if(isset($_SESSION["itensVenda"])){
            $itensVenda = $_SESSION["itensVenda"];

            foreach($itensVenda as $key => $itemVenda){
                if(in_array($id, $itemVenda)){
                    unset($itensVenda[$key]);
                }
            }
            $_SESSION["itensVenda"] = $itensVenda;
        }
    }

    if($return){
        echo "Objeto $page foi excluido";
    }
    else{
        echo "Não foi possivel excluir";
    }
}