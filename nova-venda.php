<?php
session_start();
$page_title = "Vendas";

require __DIR__ . '/include/header.php';
require __DIR__ . '/config/db.php';
require __DIR__ . '/objetos/produto.php';
require __DIR__ . '/objetos/tipo_produto.php';
require __DIR__ . '/objetos/venda.php';
require __DIR__ . '/objetos/item_venda.php';

$database = new Database();
$db = $database->getConnection();

$venda = new Venda($db);
$itemVenda = new ItemVenda($db);
$produto = new Produto($db);
$tipoProduto = new TipoProduto($db);

if($_POST){
    
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
            
            $itensVenda = $_SESSION["itensVenda"];
            $valor_total_venda = 0;
            $valor_total_imposto_venda = 0;

            foreach ($itensVenda as $itemSelecionado) {
                $produto->produto_id = $itemSelecionado[0];
                $produto->getProdutoById();
                
                $quantidade = $itemSelecionado[1];
                $valorTotal = $produto->preco * $itemSelecionado[1];

                $tipoProduto->tipo_produto_id = $produto->tipo_produto_id;
                $tipoProduto->getTipoProdutoById();

                $valor_total_imposto = $valorTotal * ($tipoProduto->percentual_imposto / 100);
                
                $valor_total_venda = $valor_total_venda + $valorTotal;
                $valor_total_imposto_venda = $valor_total_imposto_venda + $valor_total_imposto;
                
                echo "<tr>";
                    echo "<td>{$produto->nome}</td>";
                    echo "<td>{$produto->preco}</td>";
                    echo "<td>{$quantidade}</td>";
                    echo "<td>R$ {$valorTotal}</td>";
                    echo "<td>R$ {$valor_total_imposto}</td>";
                echo "</tr>";
            }
        echo "</table>";
    echo "</div>";
    echo "<div class='pull-left'>";
        echo "<h3><b>Valor total da Venda:</b> R$ " . $valor_total_venda . "</h3>";
        echo "<h3><b>Valor total imposto:</b> R$ " . $valor_total_imposto_venda . "</h3>";
    echo "</div>";
echo "</div>";

require __DIR__ . '/include/footer.php';