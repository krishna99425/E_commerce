<?php
// 'product' object
class Product{
 
    // database connection and table name
    private $conn;
    private $table_name="products";
 
    // object properties
    public $id;
    public $name;
    public $price;
    public $description;
    public $category_id;
    public $category_name;
    public $timestamp;
 
    // constructor
    public function __construct($db){
        $this->conn = $db;
    }
    // read all product based on product ids included in the $ids variable
// reference http://stackoverflow.com/a/10722827/827418
public function readByIds($ids){
 
    $ids_arr = str_repeat('?,', count($ids) - 1) . '?';
 
    // query to select products
    $query = "SELECT id, name, price FROM " . $this->table_name . " WHERE id IN ({$ids_arr}) ORDER BY name";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute($ids);
 
    // return values from database
    return $stmt;
}
// used when filling up the update product form
function readOne(){
 
    // query to select single record
    $query = "SELECT
                name, description, price
            FROM
                " . $this->table_name . "
            WHERE
                id = ?
            LIMIT
                0,1";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // sanitize
    $this->id=htmlspecialchars(strip_tags($this->id));
 
    // bind product id value
    $stmt->bindParam(1, $this->id);
 
    // execute query
    $stmt->execute();
 
    // get row values
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // assign retrieved row value to object properties
    $this->name = $row['name'];
    $this->description = $row['description'];
    $this->price = $row['price'];
}
}