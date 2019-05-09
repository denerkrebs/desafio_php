<?php

$page_title = "Vendas";

require __DIR__ . '/include/header.php';
require __DIR__ . '/config/db.php';
require __DIR__ . '/objetos/produto.php';
require __DIR__ . '/objetos/venda.php';
require __DIR__ . '/objetos/item_venda.php';

$database = new Database();
$db = $database->getConnection();

$venda = new Venda($db);
$venda->valor_total_venda = 0;
$venda->valor_total_imposto_venda = 0;
$venda->create();

$itemVenda = new ItemVenda($db);
$produto = new Produto($db);

$itemVendas = array($itemVenda);

if($_POST){
    $itemVenda->produto_id = $_POST['produto_id'];
    $itemVenda->quantidade = $_POST['quantidade'];
    $itemVenda->valor_total = ""; 
    $itemVenda->valor_total_imposto = ""; 
}

?>

<form action="buscar-produtos.php" method="post">
    <div class="panel panel-primary">
        <div class="panel-heading">Buscar produto</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-10">
                    <div class="form-group">
                        <input type='text' name='query' class='form-control' />
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <button type="submit" class="btn btn-default btn-block">Buscar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="panel panel-primary">
        <div class="panel-heading">Itens</div>
        <div class="panel-body">

        <table class='table table-hover table-responsive'>
            <thead>
            <tr>
                <th>Produto</th>
                <th>Preço</th>
                <th>Quantidade</th>
                <th>Valor Total</th>
                <th>Valor Total Imposto</th>
            </tr>
            </thead>
            <?php
            foreach ($itemVendas as $itemVenda) {
                echo "<tr>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td>{$itemVenda->quantidade}</td>";
                    echo "<td>{$itemVenda->valor_total}</td>";
                    echo "<td>{$itemVenda->valor_total_imposto}</td>";
                echo "</tr>";
            }
        echo "</div>";
    echo "</div>";
echo "</div>";

require __DIR__ . '/include/footer.php';