<?php
class Produto{ 
    private $conn;
    private $table_name = "produto";
 
    public $produto_id;
    public $nome;
    public $preco;
    public $tipo_produto_id;
 
    public function __construct($db){
        $this->conn = $db;
    }
 
    function create(){
        $query = "INSERT INTO
                    " . $this->table_name . "
                    (nome,preco,tipo_produto_id) 
                VALUES
                    (:nome,:preco,:tipo_produto_id)";

        $stmt = $this->conn->prepare($query);
        
        $this->nome=htmlspecialchars(strip_tags($this->nome));
        $this->preco=htmlspecialchars(strip_tags($this->preco));
        $this->tipo_produto_id=htmlspecialchars(strip_tags($this->tipo_produto_id));
        
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":preco", $this->preco);
        $stmt->bindParam(":tipo_produto_id", $this->tipo_produto_id);
        
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    function update(){
        $query = "UPDATE " 
                    . $this->table_name . " 
                SET 
                    nome = :nome, 
                    preco = :preco, 
                    tipo_produto_id = :tipo_produto_id 
                WHERE 
                    produto_id = :produto_id";
    
        $stmt = $this->conn->prepare($query);
    
        $this->nome=htmlspecialchars(strip_tags($this->nome));
        $this->preco=htmlspecialchars(strip_tags($this->preco));
        $this->tipo_produto_id=htmlspecialchars(strip_tags($this->tipo_produto_id));
        $this->produto_id=htmlspecialchars(strip_tags($this->produto_id));
    
        $stmt->bindParam(":produto_id", $this->produto_id);
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":preco", $this->preco);
        $stmt->bindParam(":tipo_produto_id", $this->tipo_produto_id);
    
        if($stmt->execute()){
            return true;
        } 
    }

    function readAll(){
        $query = "SELECT
                    produto_id, nome, preco, tipo_produto_id
                FROM
                    " . $this->table_name . "
                ORDER BY
                    nome ASC";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
     
        return $stmt;
    }

    function delete(){
        $query = "DELETE FROM " . $this->table_name . " WHERE produto_id = ?";
         
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->produto_id);
     
        if($result = $stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    function buscarProdutoId(){
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . "
                WHERE
                    produto_id = ?";
     
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->produto_id);
        $stmt->execute();
     
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
        $this->nome = $row['nome'];;
        $this->preco = $row['preco'];
        $this->tipo_produto_id = $row['tipo_produto_id'];
    }

    function getProdutosByNome($string){
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . "
                WHERE 
                    nome LIKE ?";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->bindValue(1, "%$string%", PDO::PARAM_STR);
        $stmt->execute();
     
        return $stmt;
    }
}