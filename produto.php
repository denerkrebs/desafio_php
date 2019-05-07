<?php

$page_title = "Produto";

require __DIR__ . '/include/header.php';
require __DIR__ . '/config/db.php';
require __DIR__ . '/objetos/produto.php';
require __DIR__ . '/objetos/tipo_produto.php';

// get ID of the product to be edited
$id = $_GET['id'];

$database = new Database();
$db = $database->getConnection();
 
$produto = new Produto($db);
$tipoProduto = new TipoProduto($db);

echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-default pull-right'>Read Products</a>";
echo "</div>";

if($id != null){
    $produto->produto_id = $id;
    $produto->buscarProdutoId($id);
}

?>
<?php

if($_POST){
    $produto->nome = $_POST['nome'];
    $produto->preco = $_POST['preco'];
    $produto->tipo_produto_id = $_POST['tipo_produto_id'];
 
    $return = $produto->create();

    if($return){
        echo "<div class='alert alert-success'>Product was created.</div>";
    }
    else{
        echo "<div class='alert alert-danger'>Unable to create product.</div>";
    }
}
?>
 
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
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
             
                    // current category of the product must be selected
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
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Registrar</button>
            </td>
        </tr>
    </table>
</form>
<?php

require __DIR__ . '/include/footer.php';