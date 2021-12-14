<?php

session_start();
// array for JSON response
$response = array();

// connecting to db
$con_string = "host=ec2-35-168-80-116.compute-1.amazonaws.com port=5432 dbname=d3cnre2oc9uli5 user=blodrftcfvyshh password=0516abc94ad85d3b4e126ff67eae2e73022401049d2862f853034cd2e5e37c61";
$con = pg_connect($con_string);

$username = NULL;
$password = NULL;

$isAuth = false;

if(isset( $_POST['email'])) {
    $username = $_POST['email'];
    $password = $_POST['senha'];
}

if(!is_null($username)){
    $query = pg_query($con, "SELECT senha, email FROM usuario WHERE email='$username'");
	if(pg_num_rows($query) > 0){
		$row = pg_fetch_array($query);
		if($password == $row['senha']){
			$isAuth = true;
		}
	}
}
 
if($isAuth) {
	$response["success"] = 1;
	
	// codigo sql da sua consulta
	$response["data"] = $username;
}
else {
	$response["success"] = 0;
	$response["error"] = "falha de autenticação";
}

pg_close($con);
echo json_encode($response);
?>