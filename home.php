<?php 

session_start();

if(!isset($_SESSION["loggedin"])){
    header("location: index.php");
    exit;
}

$page_title = "Home";

require __DIR__ . '/include/header.php'; 

if($_POST){
    $_SESSION = array();
    session_destroy();
    header("location: index.php");
    exit;
}
?>

<div class=row>
    <a href="produtos.php" class="btn btn-primary">Produtos</a>
    <a href="tipos-produto.php" class="btn btn-primary">Tipos produto</a>
    <a href="nova-venda.php" class="btn btn-primary">Nova venda</a>
    <a href="registrar-usuario.php" class="btn btn-primary">Novo usuário</a>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <div class='pull-right'>
            <button type='submit' name='logout' class='btn btn-default'>Logout</button>
        </div>
    </form>
</div>