<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/product.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$product = new Product($db);
 
// set ID property of product to be edited
$product->id = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of product to be edited
$product->readOne();
 
// create array
$product_arr = array(
    "id" =>  $product->id,
    "name" => $product->name,
    "description" => $product->description,
    "price" => $product->price,
    "category_id" => $product->category_id,
    "category_name" => $product->category_name
 
);
 
// used when filling up the update product form
function readOne(){
    
       // query to read single record
       $query = "SELECT
                   c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
               FROM
                   " . $this->table_name . " p
                   LEFT JOIN
                       categories c
                           ON p.category_id = c.id
               WHERE
                   p.id = ?
               LIMIT
                   0,1";
    
       // prepare query statement
       $stmt = $this->conn->prepare( $query );
    
       // bind id of product to be updated
       $stmt->bindParam(1, $this->id);
    
       // execute query
       $stmt->execute();
    
       // get retrieved row
       $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
       // set values to object properties
       $this->name = $row['name'];
       $this->price = $row['price'];
       $this->description = $row['description'];
       $this->category_id = $row['category_id'];
       $this->category_name = $row['category_name'];
   }
// make it json format
print_r(json_encode($product_arr));
?>