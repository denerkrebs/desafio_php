<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
</head>
<body>
    <div class="container">


<?php
require __DIR__ . '/config/db.php';
require __DIR__ . '/objetos/produto.php';
require __DIR__ . '/objetos/tipo_produto.php';

if($_POST){
    $database = new Database();
    $db = $database->getConnection();

    $produto = new Produto($db);
    $tipoProduto = new TipoProduto($db);

    $query = $_POST['object_query'];

    $stmt = $produto->getProdutoByNome($query);
    $num = $stmt->rowCount();

    if($num > 0){
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
                    echo "<div class='btn-group pull-right'>";
                    echo "<a delete-id='{$produto_id}' class='btn btn-primary'>
                    <span class='glyphicon glyphicon-plus-'></span> Adicionar
                    </a>";
                    echo "</div>";
                    echo "</td>";

                echo "</tr>";
            }

        echo "</table>";
    }
    else{
        echo "<div class='alert alert-info'>Nenhum produto cadastrada foi encontrado</div>";
    }
}

require __DIR__ . '/include/footer.php';