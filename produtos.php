<?php

$page_title = "Produtos";

require __DIR__ . '/include/header.php';
require __DIR__ . '/config/db.php';
require __DIR__ . '/objetos/produto.php';
require __DIR__ . '/objetos/tipo_produto.php';

echo "<div class='right-button-margin'>";
    echo "<a href='produto.php' class='btn btn-default pull-right'>Criar Produto</a>";
echo "</div>";
 
$database = new Database();
$db = $database->getConnection();
 
$produto = new Produto($db);
$tipoProduto = new TipoProduto($db);

$stmt = $produto->readAll();
$num = $stmt->rowCount();

if($num > 0){
    echo "<table class='table table-hover table-responsive table-bordered'>";
        echo "<tr>";
            echo "<th>Produto</th>";
            echo "<th>Preço</th>";
            echo "<th>Tipo de produto</th>";
        echo "</tr>";
 
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
 
            extract($row);
 
            echo "<tr>";
                echo "<td>{$nome}</td>";
                echo "<td>{$preco}</td>";
                echo "<td>";
                    $tipoProduto->tipo_produto_id = $tipo_produto_id;
                    $tipoProduto->readName();
                    echo $tipoProduto->nome;
                echo "</td>";
 
                echo "<td>";
                echo "<a href='read_one.php?id={$produto_id}' class='btn btn-primary left-margin'>
                <span class='glyphicon glyphicon-list'></span> Read
                </a>

                <a href='produto.php?id={$produto_id}' class='btn btn-info left-margin'>
                <span class='glyphicon glyphicon-edit'></span> Edit
                </a>

                <a delete-id='{$produto_id}' class='btn btn-danger delete-object'>
                <span class='glyphicon glyphicon-remove'></span> Delete
                </a>";
                echo "</td>";
 
            echo "</tr>";
        }
 
    echo "</table>";
}
else{
    echo "<div class='alert alert-info'>No products found.</div>";
}

require __DIR__ . '/include/footer.php';