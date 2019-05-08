<?php

$page_title = "Tipo produto";

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
                        <input type='text' name='percentual_imposto' class='form-control' />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pull-right">
        <a href="tipos-produto.php" class="btn btn-default">Voltar</a>
        <button type="submit" class="btn btn-primary">Salvar</button>
    </div>
</form>
<?php

require __DIR__ . '/include/footer.php';