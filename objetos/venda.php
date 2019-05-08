<?php
class Venda{
    private $conn;
    private $table_name = "venda";

    public $venda_id;
    public $valor_total_venda;
    public $valor_total_imposto_venda;

    public function __construct($db){
        $this->conn = $db;
    }
 
    function create(){
        $query = "INSERT INTO
                    " . $this->table_name . "
                    (valor_total_venda, valor_total_imposto_venda) 
                VALUES
                    (:valor_total_venda, :valor_total_imposto_venda)";

        $stmt = $this->conn->prepare($query);
        
        $this->valor_total_venda=htmlspecialchars(strip_tags($this->valor_total_venda));
        $this->valor_total_imposto_venda=htmlspecialchars(strip_tags($this->valor_total_imposto_venda));
        
        $stmt->bindParam(":valor_total_venda", $this->valor_total_venda);
        $stmt->bindParam(":valor_total_imposto_venda", $this->valor_total_imposto_venda);
        
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
}