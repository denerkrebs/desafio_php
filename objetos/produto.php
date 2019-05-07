<?php
class Produto{ 
    private $conn;
    private $table_name = "produto";
 
    // object properties
    public $produto_id;
    public $nome;
    public $preco;
    public $tipo_produto_id;
 
    public function __construct($db){
        $this->conn = $db;
    }
 
    function create(){
        try{
            $query = "INSERT INTO 
                        " . $this->table_name . "
                    (nome,preco,tipo_produto_id) VALUES(:nome,:preco,:tipo_produto_id)";

            $stmt = $this->conn->prepare($query);
            
            // posted values
            $this->nome=htmlspecialchars(strip_tags($this->nome));
            $this->preco=htmlspecialchars(strip_tags($this->preco));
            $this->tipo_produto_id=htmlspecialchars(strip_tags($this->tipo_produto_id));
            
            // bind values 
            $stmt->bindParam(":nome", $this->nome);
            $stmt->bindParam(":preco", $this->preco);
            $stmt->bindParam(":tipo_produto_id", $this->tipo_produto_id);
            
            if($stmt->execute()){
                return true;
            }else{
                return false;
            }
        } catch (exception $e){
            return $e->getMessage();
        }
    }
}