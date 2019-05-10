<?php

session_start();

if(!isset($_SESSION["loggedin"])){
    header("location: index.php");
    exit;
}

$page_title = "Tipo produto";

require __DIR__ . '/include/header.php';
require __DIR__ . '/config/db.php';
require __DIR__ . '/objetos/tipo_produto.php';

$database = new Database();
$db = $database->getConnection();
 
$tipoProduto = new TipoProduto($db);

if($_POST){
    $tipoProduto->nome = $_POST['nome'];
    $tipoProduto->percentual_imposto = $_POST['percentual_imposto'];

    $return = $tipoProduto->create();

    if($return){
        header("Location: tipos-produto.php");
        die();
    }
    else{
        echo "<div class='alert alert-danger'>Não foi realizar a ação</div>";
    }
}
?>
 
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <div class="panel panel-primary">
        <div class="panel-heading">Novo tipo produto</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Tipo de produto</label>
                        <input type='text' name='nome' class='form-control' />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Percentual imposto</label>
                        <input type='number' min="0" name='percentual_imposto' class='form-control' />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="btn-group pull-right">
        <a href="tipos-produto.php" class="btn btn-default">Voltar</a>
        <button type="submit" class="btn btn-primary">Salvar</button>
    </div>
</form>
<?php

require __DIR__ . '/include/footer.php';