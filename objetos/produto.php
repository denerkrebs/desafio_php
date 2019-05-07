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

    function update(){
 
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    name = :name,
                    price = :price,
                    description = :description,
                    category_id  = :category_id
                WHERE
                    id = :id";
     
        $stmt = $this->conn->prepare($query);
     
        // posted values
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->price=htmlspecialchars(strip_tags($this->price));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->category_id=htmlspecialchars(strip_tags($this->category_id));
        $this->id=htmlspecialchars(strip_tags($this->id));
     
        // bind parameters
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':id', $this->id);
     
        // execute the query
        if($stmt->execute()){
            return true;
        }
     
        return false;
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

    // used for paging products
    public function countAll(){
        $query = "SELECT id FROM " . $this->table_name . "";
    
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
    
        $num = $stmt->rowCount();
    
        return $num;
    }

    function buscarProdutoId($produto_id){
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . "
                WHERE
                    produto_id = ?";
     
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $produto_id);
        $stmt->execute();
     
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
        $this->nome = $row['nome'];;
        $this->preco = $row['preco'];
        $this->tipo_produto_id = $row['tipo_produto_id'];
    }
}