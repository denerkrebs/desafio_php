<?php

$id = isset($_GET['id']) ? $_GET['id'] : die('Erro! Parametro não definido');

$page_title = "Tipo do produto";

require __DIR__ . '/include/header.php';
require __DIR__ . '/config/db.php';
require __DIR__ . '/objetos/tipo_produto.php';

$database = new Database();
$db = $database->getConnection();
 
$tipoProduto = new TipoProduto($db);

$tipoProduto->tipo_produto_id = $id;
$tipoProduto->getTipoProdutoById();

if($_POST){
    $tipoProduto->nome = $_POST['nome'];
    $tipoProduto->percentual_imposto = $_POST['percentual_imposto'];

    $return = $tipoProduto->update();

    if($return){
        header("Location: tipos-produto.php");
        die();
    }
    else{
        echo "<div class='alert alert-danger'>Não foi realizar a ação</div>";
    }
}
?>
 
 <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
    <div class="panel panel-primary">
        <div class="panel-heading">Editar tipo produto</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Tipo de produto</label>
                        <input type='text' name='nome' value='<?php echo $tipoProduto->nome; ?>' class='form-control' />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Percentual imposto</label>
                        <input type='text' name='percentual_imposto' value='<?php echo $tipoProduto->percentual_imposto; ?>' class='form-control' />
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