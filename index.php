<?php
session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: home.php");
    exit;
}

$page_title = "Login";

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
        $senha = $_POST['password'];
        
        $return = $usuario->getUsuario();
        
            if(password_verify($senha, $usuario->senha)){
                session_start();
                
                $_SESSION["loggedin"] = true;
                $_SESSION["usuario_id"] = $usuario->usuario_id;
                $_SESSION["nome_usuario"] = $usuario->nome_usuario;
                
                header("location: home.php");
            } else {
                echo "<div class='alert alert-success'>Senha invalida</div>";
            }
    }
}

?>
<div class="wrapper">
    <div class="col-md-4 col-md-offset-4">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Usuário</label>
                <input type="text" name="username" class="form-control" value="<?php echo $usuario->nome_usuario; ?>">
            </div>    
            <div class="form-group">
                <label>Senha</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
        </form>
    </div>
</div>

<?php require __DIR__ . '/include/footer.php'; ?>