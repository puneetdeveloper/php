<?php
// show error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);
 
// home page url
$home_url="http://localhost:9090/api";
 
// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;
 
// set number of records per page
$records_per_page = 5;
 
// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;

// read products with pagination
public function readPaging($from_record_num, $records_per_page){
    
       // select query
       $query = "SELECT
                   c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
               FROM
                   " . $this->table_name . " p
                   LEFT JOIN
                       categories c
                           ON p.category_id = c.id
               ORDER BY p.created DESC
               LIMIT ?, ?";
    
       // prepare query statement
       $stmt = $this->conn->prepare( $query );
    
       // bind variable values
       $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
       $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
    
       // execute query
       $stmt->execute();
    
       // return values from database
       return $stmt;
   }
?>