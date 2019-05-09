<?php

$page_title = "Produtos";

require __DIR__ . '/include/header.php';
require __DIR__ . '/config/db.php';
require __DIR__ . '/objetos/produto.php';
require __DIR__ . '/objetos/tipo_produto.php';

if($_POST){
    $string = $_POST['query'];

    $database = new Database();
    $db = $database->getConnection();

    $produto = new Produto($db);
    $tipoProduto = new TipoProduto($db);

    $stmt = $produto->getProdutosByNome($string);
    $num = $stmt->rowCount();

    if($num > 0){
        echo "<form action='nova-venda.php' method='post'>";
            echo "<table class='table table-hover table-responsive'>";
                echo "<thead>";
                echo "<tr>";
                    echo "<th>Produto</th>";
                    echo "<th>Preço</th>";
                    echo "<th>Tipo de produto</th>";
                    echo "<th>Percentual imposto</th>";
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
                            echo "<button type='submit' class='btn btn-primary btn-block'>Adicionar</button>";
                        echo "</td>";
                    echo "</tr>";
                }

            echo "</table>";
        echo "</form>";
    }
    else{
        echo "<div class='alert alert-info'>Nenhum produto cadastrada foi encontrado</div>";
    }
}
require __DIR__ . '/include/footer.php';