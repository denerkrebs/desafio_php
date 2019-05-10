<?php
session_start();

if(!isset($_SESSION["loggedin"])){
    header("location: index.php");
    exit;
}

$page_title = "Vendas";

require __DIR__ . '/include/header.php';
require __DIR__ . '/config/db.php';
require __DIR__ . '/objetos/produto.php';
require __DIR__ . '/objetos/tipo_produto.php';
require __DIR__ . '/objetos/venda.php';

$database = new Database();
$db = $database->getConnection();

$venda = new Venda($db);
$produto = new Produto($db);
$tipoProduto = new TipoProduto($db);

$valor_total_venda = 0;
$valor_total_imposto_venda = 0;

if($_POST){
    $totalVenda = $_SESSION["ValorTotalVenda"];
    $totalImposto =  $_SESSION["ValorTotalImpostoVenda"];

    if($totalImposto != 0 && $totalVenda != 0){
        $venda->valor_total_venda = $totalVenda;
        $venda->valor_total_imposto_venda = $totalImposto;

        $venda->usuario_id = $_SESSION["usuario_id"];
        
        $return = $venda->create();

        if($return){
            echo "<div class='alert alert-success'>Venda foi registrado</div>";

            $_SESSION["ValorTotalVenda"] = 0;
            $_SESSION["ValorTotalImpostoVenda"] = 0;
            $_SESSION["itensVenda"] = array();
        }
        else{
            echo "<div class='alert alert-danger'>Não foi realizar a ação</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Nenhum produto adicionado</div>";
    }
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

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
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
                    <th></th>
                </tr>
                </thead>
                <?php
                
                if(isset($_SESSION["itensVenda"])){
                    $itensVenda = $_SESSION["itensVenda"];

                    foreach ($itensVenda as $itemSelecionado) {
                        $produto->produto_id = $itemSelecionado[0];
                        $produto->getProdutoById();
                        
                        $quantidade = $itemSelecionado[1];
                        $valorTotal = $produto->preco * intval($quantidade);

                        $tipoProduto->tipo_produto_id = $produto->tipo_produto_id;
                        $tipoProduto->getTipoProdutoById();

                        $valor_total_imposto = $valorTotal * ($tipoProduto->percentual_imposto / 100);
                        
                        $valor_total_venda = $valor_total_venda + $valorTotal;
                        $valor_total_imposto_venda = $valor_total_imposto_venda + $valor_total_imposto;

                        $_SESSION["ValorTotalVenda"] = $valor_total_venda;
                        $_SESSION["ValorTotalImpostoVenda"] = $valor_total_imposto_venda;
                        
                        echo "<tr>";
                            echo "<td>{$produto->nome}</td>";
                            echo "<td>{$produto->preco}</td>";
                            echo "<td>{$quantidade}</td>";
                            echo "<td>R$ {$valorTotal}</td>";
                            echo "<td>R$ {$valor_total_imposto}</td>";
                            
                            echo "<td>";
                                echo "<div class='btn-group pull-right'>";
                                    echo "<a delete-id='{$produto->produto_id}' page='venda' class='btn btn-danger delete-object'>
                                    <span class='glyphicon glyphicon-remove'></span></a>";
                                echo "</div>";
                            echo "</td>";
                        echo "</tr>";
                    }
                }
            echo "</table>";
        echo "</div>";
    echo "</div>";
    echo "<div class='row'>";
        echo "<div class='col-sm-6'>";
            if($valor_total_venda != 0){
                echo "<div class='pull-left'>";
                    echo "<h4><b>Valor total da venda:</b> R$ " . $valor_total_venda . "</h4>";
                    echo "<input id='valorTotalVenda' class='hide' value='$valor_total_venda'>";
                    echo "<h4><b>Valor total imposto:</b> R$ " . $valor_total_imposto_venda . "</h4>";
                    echo "<input id='valorTotalImpostoVenda' class='hide' value='$valor_total_imposto_venda'>";
                echo "</div>";
            }
        echo "</div>";
        echo "<div class='col-sm-6'>";
            echo "<div class='btn-group pull-right'>";
                echo "<a href='index.php' class='btn btn-default'>Voltar</a>";
                echo "<button type='submit' name='btnSalvar' class='btn btn-primary'>Salvar</button>";
            echo "</div>";
        echo "</div>";
    echo "</div>";
echo "</form>";

require __DIR__ . '/include/footer.php';