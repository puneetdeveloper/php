<?php
class Product{
 
    // database connection and table name
    private $conn;
    private $table_name = "products";
 
    // object properties
    public $id;
    public $name;
    public $description;
    public $price;
    public $category_id;
    public $category_name;
    public $created;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    function read(){
        
           // select all query
           $query = "SELECT
                       c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
                   FROM
                       " . $this->table_name . " p
                       LEFT JOIN
                           categories c
                               ON p.category_id = c.id
                   ORDER BY
                       p.created DESC";
        
           // prepare query statement
           $stmt = $this->conn->prepare($query);
        
           // execute query
           $stmt->execute();
        
           return $stmt;
       }
       // used for paging products
public function count(){
    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    return $row['total_rows'];
}
}