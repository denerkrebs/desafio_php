<?php

$page_title = "Novo tipo do produto";

require __DIR__ . '/include/header.php';
require __DIR__ . '/config/db.php';
require __DIR__ . '/objetos/tipo_produto.php';

$database = new Database();
$db = $database->getConnection();
 
$tipoProduto = new TipoProduto($db);

?>
<?php

if($_POST){
    $tipoProduto->nome = $_POST['nome'];
    $tipoProduto->percentual_imposto = $_POST['percentual_imposto'];

    $return = $tipoProduto->create();

    if($return){
        echo "<div class='alert alert-success'>Tipo produto registrado</div>";
    }
    else{
        echo "<div class='alert alert-danger'>Não foi realizar a ação</div>";
    }
}
?>
 
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
        <tr>
            <td>Tipo de produto</td>
            <td><input type='text' name='nome' value='<?php echo $tipoProduto->nome; ?>' class='form-control' /></td>
        </tr>
        <tr>
            <td>Percentual imposto</td>
            <td><input type='text' name='percentual_imposto' value='<?php echo $tipoProduto->percentual_imposto; ?>' class='form-control' /></td>
        </tr>
    </table>
    <div class="pull-right">
        <a href="index.php" class="btn btn-default">Voltar</a>
        <button type="submit" class="btn btn-primary">Salvar</button>
    </div>
</form>
<?php

require __DIR__ . '/include/footer.php';