<?php
class TipoProduto{
    private $conn;
    private $table_name = "tipo_produto";
 
    public $tipo_produto_id;
    public $nome;
    public $percentual_imposto;
 
    public function __construct($db){
        $this->conn = $db;
    }

    function create(){
        $query = "INSERT INTO
                    " . $this->table_name . "
                    (nome, percentual_imposto) 
                VALUES
                    (:nome, :percentual_imposto)";

        $stmt = $this->conn->prepare($query);
        
        $this->nome=htmlspecialchars(strip_tags($this->nome));
        $this->percentual_imposto=htmlspecialchars(strip_tags($this->percentual_imposto));
        
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":percentual_imposto", $this->percentual_imposto);
        
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    function delete(){
        $query = "DELETE FROM " . $this->table_name . " WHERE tipo_produto_id = ?";
         
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->tipo_produto_id);
     
        if($result = $stmt->execute()){
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
                    percentual_imposto = :percentual_imposto, 
                WHERE
                    produto_id = :produto_id";
    
        $stmt = $this->conn->prepare($query);
    
        $this->nome=htmlspecialchars(strip_tags($this->nome));
        $this->percentual_imposto=htmlspecialchars(strip_tags($this->percentual_imposto));
    
        $stmt->bindParam(":produto_id", $this->tipo_produto_id);
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":percentual_imposto", $this->percentual_imposto);
    
        if($stmt->execute()){
            return true;
        } 
    }
 
    function read(){
        $query = "SELECT
                    tipo_produto_id, nome
                FROM
                    " . $this->table_name . "
                ORDER BY
                    nome";  
 
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
 
        return $stmt;
    }

    function getTipoProdutoById(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE tipo_produto_id = ?";
    
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->tipo_produto_id);
        $stmt->execute();
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->nome = $row['nome'];
        $this->percentual_imposto = $row['percentual_imposto']; 
    }

    function getAll(){
 
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . "
                ORDER BY
                    nome ASC";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
     
        return $stmt;
    }
}
