<body>
    <div class="container">
        <div class='page-header'>
            <h1>Vendas</h1>
        </div>
<?php

$page_title = "Produtos";

require __DIR__ . '/include/header.php';
require __DIR__ . '/config/db.php';
require __DIR__ . '/objetos/produto.php';
require __DIR__ . '/objetos/tipo_produto.php';

echo "<div class='right-button-margin'>";
    echo "<a href='produto.php' class='btn btn-primary pull-right'>Criar Produto</a>";
echo "</div>";
 
$database = new Database();
$db = $database->getConnection();
 
$produto = new Produto($db);
$tipoProduto = new TipoProduto($db);

$stmt = $produto->readAll();
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
                echo "<a href='editar-produto.php?id={$produto_id}' class='btn btn-info '>
                <span class='glyphicon glyphicon-edit'></span> Editar
                </a>

                <a delete-id='{$produto_id}' page='produto' class='btn btn-danger delete-object'>
                <span class='glyphicon glyphicon-remove'></span> Excluir
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

require __DIR__ . '/include/footer.php';