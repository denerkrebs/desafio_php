<?php
session_start();

// if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
//     header("location: home.php");
//     exit;
// }

$page_title = "Registrar usuário";

require __DIR__ . '/config/db.php';
require __DIR__ . '/include/header.php';
require __DIR__ . '/objetos/usuario.php';

$database = new Database();
$db = $database->getConnection();
 
$usuario = new Usuario($db);

if($_POST){
    if(empty(trim($_POST['username'])) || empty(trim($_POST['password']))){
        echo "<div class='alert alert-warning'>Insira o nome de usuário e senha</div>";
    } else {
        $usuario->nome_usuario = $_POST['username'];
        $usuario->senha = $_POST['password'];
        
        $return = $usuario->create();

        if($return){
            echo "<div class='alert alert-success'>Usuario foi registrado</div>";
        }
        else{
            echo "<div class='alert alert-danger'>Não foi realizar a ação</div>";
        }
    }
}

?>

<div class="wrapper">
    <div class="col-sm-8">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Usuário</label>
                <input type="text" name="username" class="form-control">
            </div>    
            <div class="form-group">
                <label>Senha</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Registrar">
            </div>
        </form>
    </div>
</div>

<?php require __DIR__ . '/include/footer.php'; ?>