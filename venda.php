<?php

$page_title = "Vendas";

require __DIR__ . '/include/header.php';
require __DIR__ . '/config/db.php';
require __DIR__ . '/objetos/produto.php';
require __DIR__ . '/objetos/venda.php';

$database = new Database();
$db = $database->getConnection();
 
$produto = new Produto($db);
$venda = new Venda($db);

if($_POST){
    $produto->nome = $_POST['nome'];
    $produto->preco = $_POST['preco'];
    $produto->tipo_produto_id = $_POST['tipo_produto_id'];

    $return = $produto->create();

    if($return){
        echo "<div class='alert alert-success'>Venda registrada</div>";
    }
    else{
        echo "<div class='alert alert-danger'>Não foi realizar a ação</div>";
    }
}
?>

<form>
    <div class="panel panel-primary">
        <div class="panel-heading">Buscar produto</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-10">
                    <div class="form-group">
                        <input id="query" type='text' class='form-control' />
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <a class="btn btn-default btn-block search">Buscar</a>
                    </div>
                    <a id="btnBuscar" class="hide" data-fancybox="" data-type="iframe" href='buscar-produtos.php'>Buscar</a>
                </div>
            </div>
        </div>
    </div>
</form>


<?php
require __DIR__ . '/include/footer.php';