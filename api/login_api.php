<?php
 header('Access-Control-Allow-Origin: *');
 header("Access-Control-Allow-Headers: *");
 $data = json_decode(file_get_contents('php://input'));

include('databaseModel.php');
include('Crud.class.php');

$username = $data->username;
$password = $data->password;



$userdata = Crud::selectcolumn('USERS',array('*'),"where username='$username' and password='$password'",$conn);

//--------------Here new connection will form  of from credentials-------------------

$check_configuration = array();
$db = $userdata[0]['db_name'];
$conn = mysqli_connect('localhost','root','12345',$db);

$branch_check = Crud::selectcolumn('BRANCHES',array('id'),"",$conn);
if($branch_check[0]['id']){
$check_configuration['branch_status'] =1; 
}else{
$check_configuration['branch_status'] =0; 

}


$user_auth = Crud::selectcolumn('USERS',array('id'),"",$conn);

if($user_auth[0]['id'])
{
$check_configuration['user_status'] = 1; 
}else{
$check_configuration['user_status'] = 0; 
}


$product_auth = Crud::selectcolumn('PRODUCT',array('id'),"",$conn);

if($product_auth[0]['id'])
{
$check_configuration['product_status'] = 1; 
}else{
$check_configuration['product_status'] = 0; 
}








$userdata[1] = $check_configuration;



echo json_encode($userdata);
       

?>
