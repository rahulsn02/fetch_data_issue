<?php
 header('Access-Control-Allow-Origin: *');
 header("Access-Control-Allow-Headers: *");
 $data = json_decode(file_get_contents('php://input'));

$db = $data->db;

$conn = mysqli_connect('localhost','root','12345',$db);
include('../Crud.class.php');

$product_category_data = array();

$data = Crud::selectcolumn("CATEGORY",array("*"),"",$conn);

foreach($data as $key=>$value){

        $product_data = Crud::selectcolumn('PRODUCT',array('*'),"where category_id='".$value['id']."' order by id desc",$conn);
        $product_category_data[$value['category_name']]  = $product_data;
  }

echo json_encode($product_category_data);
       

       

?>
