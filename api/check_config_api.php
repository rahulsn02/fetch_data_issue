<?php
 header('Access-Control-Allow-Origin: *');
 header("Access-Control-Allow-Headers: *");
 $data = json_decode(file_get_contents('php://input'));

$db = $data->db;

$conn = mysqli_connect('localhost','root','12345',$db);
include('Crud.class.php');
$auth_data = array();

$branch_auth = Crud::selectcolumn('BRANCHES',array('id'),"",$conn);

if($branch_auth[0]['id'])
{
$auth_data['branch_status'] = 1; 
}else{
$auth_data['branch_status'] = 0; 
}


$user_auth = Crud::selectcolumn('USERS',array('id'),"",$conn);

if($user_auth[0]['id'])
{
$auth_data['user_status'] = 1; 
}else{
$auth_data['user_status'] = 0; 
}






$product_auth = Crud::selectcolumn('PRODUCT',array('id'),"",$conn);

if($product_auth[0]['id'])
{
$auth_data['product_status'] = 1; 
}else{
$auth_data['product_status'] = 0; 
}







//print_r($branch_data);

echo json_encode($auth_data);
       

?>
