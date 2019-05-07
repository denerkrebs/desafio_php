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

    function readName(){
        $query = "SELECT nome FROM " . $this->table_name . " WHERE tipo_produto_id = ?";
    
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->tipo_produto_id);
        $stmt->execute();
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->nome = $row['nome'];
    }
}
