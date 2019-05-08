<?php

$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR');

$page_title = "Editar produto";

require __DIR__ . '/include/header.php';
require __DIR__ . '/config/db.php';
require __DIR__ . '/objetos/produto.php';
require __DIR__ . '/objetos/tipo_produto.php';

$database = new Database();
$db = $database->getConnection();
 
$produto = new Produto($db);
$tipoProduto = new TipoProduto($db);

$produto->produto_id = $id;
$produto->buscarProdutoId();

?>
<?php
if($_POST){
    $produto->nome = $_POST['nome'];
    $produto->preco = $_POST['preco'];
    $produto->tipo_produto_id = $_POST['tipo_produto_id'];

    $return = $produto->update();

    if($return){
        echo "<div class='alert alert-success'>Produto alterado</div>";
    }
    else{
        echo "<div class='alert alert-danger'>Não foi realizar a alteração</div>";
    }
}
?>
 
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
        <tr>
            <td>Produto</td>
            <td><input type='text' name='nome' value='<?php echo $produto->nome; ?>' class='form-control' /></td>
        </tr>
        <tr>
            <td>Preço</td>
            <td><input type='text' name='preco' value='<?php echo $produto->preco; ?>' class='form-control' /></td>
        </tr>
        <tr>
            <td>Tipo Produto</td>
            <td>
            <?php

            $stmt = $tipoProduto->read();
            echo "<select class='form-control' name='tipo_produto_id'>";
                echo "<option>Selecionar tipo produto</option>";
                
                while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $tipo_produto_id=$row_category['tipo_produto_id'];
                    $nome = $row_category['nome'];
             
                    if($produto->tipo_produto_id==$tipo_produto_id){
                        echo "<option value='$tipo_produto_id' selected>";
                    }else{
                        echo "<option value='$tipo_produto_id'>";
                    }
             
                    echo "$nome</option>";
                }

            echo "</select>";
            ?>
            </td>
        </tr>
    </table>
    <div class="pull-right">
        <a href="produtos.php" class="btn btn-default">Voltar</a>
        <button type="submit" class="btn btn-primary">Salvar</button>
    </div>
</form>
<?php

require __DIR__ . '/include/footer.php';