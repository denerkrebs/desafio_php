<?php
class Usuario{
    private $conn;
    private $table_name = "usuario";

    public $usuario_id;
    public $nome_usuario;
    public $senha;

    public function __construct($db){
        $this->conn = $db;
    }

    function getUsuario(){
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . "
                WHERE 
                    nome_usuario = :nome_usuario";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->nome_usuario);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->usuario_id = $row['usuario_id'];;
        $this->nome_usuario = $row['nome_usuario'];
        $this->senha = $row['senha'];
    }

    function create(){
        $query = "INSERT INTO
                    " . $this->table_name . "
                    (nome_usuario, senha) 
                VALUES
                    (:nome_usuario,:senha)";

        $stmt = $this->conn->prepare($query);
        
        $this->nome_usuario=htmlspecialchars(strip_tags($this->nome_usuario));
        $this->senha=htmlspecialchars(strip_tags($this->senha));
        
        $stmt->bindParam(":nome_usuario", $this->nome_usuario);
        $stmt->bindParam(":senha", password_hash($this->senha, PASSWORD_DEFAULT));
        
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
}