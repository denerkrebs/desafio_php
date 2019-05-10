<?php
session_start();

if(!isset($_SESSION["loggedin"])){
    header("location: index.php");
    exit;
}

$page_title = "Busca";

require __DIR__ . '/include/header.php';
require __DIR__ . '/config/db.php';
require __DIR__ . '/objetos/produto.php';
require __DIR__ . '/objetos/tipo_produto.php';

$string = "";

if (isset($_SESSION["itensVenda"])){
    $itensVenda = $_SESSION["itensVenda"];
} else {
    $itensVenda = array();
    $_SESSION["itensVenda"] = $itensVenda;
}

if($_POST){
    if(isset($_POST['query'])){
        $string = $_POST['query'];
    } else {
        $produto_id = $_POST['produto_id'];
        $quantidade = $_POST['quantidade'];
        
        foreach($itensVenda as $key => $itemVenda){
            if(in_array($produto_id, $itemVenda)){
                $quantidade = $itemVenda[1] + $quantidade;
                
                unset($itensVenda[$key]);
            }
        }

        $itemSelecionado = array($produto_id, $quantidade);

        array_push($itensVenda, $itemSelecionado);
        $_SESSION["itensVenda"] = $itensVenda;
        
        sizeof($itensVenda);
        
        header('Location: /nova-venda.php');
        die();
    }
}

$database = new Database();
$db = $database->getConnection();

$produto = new Produto($db);
$tipoProduto = new TipoProduto($db);

$stmt = $produto->getProdutosByNome($string);
$num = $stmt->rowCount();

if($num > 0){
    echo "<form action='buscar-produtos.php' method='post'>";
        echo "<table class='table table-hover table-responsive'>";
            echo "<thead>";
            echo "<tr>";
                echo "<th>Produto</th>";
                echo "<th>Preço</th>";
                echo "<th>Tipo de produto</th>";
                echo "<th>Percentual imposto</th>";
                echo "<th>Quantidade</th>";
            echo "</tr>";
            echo "</thead>";

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);

                echo "<tr>";
                    echo "<td>{$nome}</td>";
                    echo "<td>{$preco}</td>";
                    echo "<td>";
                        $tipoProduto->tipo_produto_id = $tipo_produto_id;
                        $tipoProduto->getTipoProdutoById();
                        echo $tipoProduto->nome;
                    echo "</td>";
                    echo "<td>";
                        $tipoProduto->tipo_produto_id = $tipo_produto_id;
                        $tipoProduto->getTipoProdutoById();
                        echo $tipoProduto->percentual_imposto + 0 . "%";
                    echo "</td>";
                    echo "<td>";
                        echo "<input type='number' name='quantidade' class='form-control'/>";
                    echo "</td>";
                    echo "<td>";
                        echo "<button name='produto_id' type='submit' value='" . $produto_id . "' class='btn btn-primary btn-block'>Adicionar</button>";
                    echo "</td>";
                echo "</tr>";
            }

        echo "</table>";
    echo "</form>";
    
}
else{
    echo "<div class='alert alert-info'>Nenhum produto cadastrado foi encontrado</div>";
}

echo "<a href='nova-venda.php' class='btn btn-default pull-right'>Voltar</a>";

require __DIR__ . '/include/footer.php';