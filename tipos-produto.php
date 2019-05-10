<?php

session_start();

if(!isset($_SESSION["loggedin"])){
    header("location: index.php");
    exit;
}

$page_title = "Tipos de produto";

require __DIR__ . '/include/header.php';
require __DIR__ . '/config/db.php';
require __DIR__ . '/objetos/tipo_produto.php';

echo "<div class='row'>";
    echo "<div class='col-sm-12'>";
        echo "<div class='btn-group pull-right'>";
            echo "<a href='index.php' class='btn btn-default'>Voltar</a>";
            echo "<a href='tipo-produto.php' class='btn btn-primary'>Adicionar tipo produto</a>";
        echo "</div>";
    echo "</div>";
echo "</div>";
 
$database = new Database();
$db = $database->getConnection();

$tipoProduto = new TipoProduto($db);

$stmt = $tipoProduto->getAll();
$num = $stmt->rowCount();

if($num > 0){
    echo "<table class='table table-hover table-responsive'>";
        echo "<thead>";
        echo "<tr>";
            echo "<th>Tipo produto</th>";
            echo "<th>Percentual imposto</th>";
        echo "</tr>";
        echo "</thead>";

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            
            $percentual_imposto = $percentual_imposto + 0;

            echo "<tr>";
                echo "<td>{$nome}</td>";
                echo "<td>{$percentual_imposto}%</td>";
 
                echo "<td>";
                echo "<div class='btn-group pull-right'>";
                echo "<a href='editar-tipo-produto.php?id={$tipo_produto_id}' class='btn btn-info '>
                <span class='glyphicon glyphicon-edit'></span> Editar
                </a>

                <a delete-id='{$tipo_produto_id}' page='tipo-produto' class='btn btn-danger delete-object'>
                <span class='glyphicon glyphicon-remove'></span> Excluir
                </a>";
                echo "</div>";
                echo "</td>";
 
            echo "</tr>";
        }
 
    echo "</table>";
}
else{
    echo "<div class='alert alert-info'>Não foi encontrado nenhum tipo de produto cadastrado</div>";
}

require __DIR__ . '/include/footer.php';