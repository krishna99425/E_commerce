<?php
// start session
session_start();
 
// include classes
include_once "config/database.php";
include_once "objects/product.php";
include_once "objects/product_image.php";
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// initialize objects
$product = new Product($db);
$product_image = new ProductImage($db);
// get ID of the product to be edited
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
 
// set the id as product id property
$product->id = $id;
 
// to read single record product
$product->readOne();
 
// set page title
$page_title = $product->name;
 
// set product id
$product_image->product_id=$id;
 
// read all related product image
$stmt_product_image = $product_image->readByProductId();
 
// count all relatd product image
$num_product_image = $stmt_product_image->rowCount();
 
echo "<div class='col-md-1'>";
    // if count is more than zero
    if($num_product_image>0){
        // loop through all product images
        while ($row = $stmt_product_image->fetch(PDO::FETCH_ASSOC)){
            // image name and source url
            $product_image_name = $row['name'];
            $source="uploads/images/{$product_image_name}";
            echo "<img src='{$source}' class='product-img-thumb' data-img-id='{$row['id']}' />";
        }
    }else{ echo "No images."; }
echo "</div>";
 
// product image will be here 
// include page header HTML
include_once 'layout_header.php';
 
// content will be here
 
// include page footer HTML
include_once 'layout_footer.php';
?>