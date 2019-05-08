<?php
class ItemVenda{
    private $conn;
    private $table_name = "venda";

    public $venda_id;
    public $produto_id;
    public $quantidade;
    public $valor_total;
    public $valor_total_imposto;

    public function __construct($db){
        $this->conn = $db;
    }
 
    function create(){
        $query = "INSERT INTO
                    " . $this->table_name . "
                    (venda_id, produto_id, quantidade, valor_total, valor_total_imposto) 
                VALUES
                    (:venda_id, :produto_id, :quantidade, :valor_total, :valor_total_imposto)";

        $stmt = $this->conn->prepare($query);
        
        $this->venda_id=htmlspecialchars(strip_tags($this->venda_id));
        $this->produto_id=htmlspecialchars(strip_tags($this->produto_id));
        $this->quantidade=htmlspecialchars(strip_tags($this->quantidade));
        $this->valor_total=htmlspecialchars(strip_tags($this->valor_total));
        $this->valor_total_imposto=htmlspecialchars(strip_tags($this->valor_total_imposto));
        
        $stmt->bindParam(":venda_id", $this->venda_id);
        $stmt->bindParam(":produto_id", $this->produto_id);
        $stmt->bindParam(":quantidade", $this->quantidade);
        $stmt->bindParam(":valor_total", $this->valor_total);
        $stmt->bindParam(":valor_total_imposto", $this->valor_total_imposto);
        
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
}