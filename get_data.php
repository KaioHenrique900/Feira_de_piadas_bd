<?php

session_start();
// array for JSON response
$response = array();

// connecting to db
$con_string = "host=ec2-35-168-80-116.compute-1.amazonaws.com port=5432 dbname=d3cnre2oc9uli5 user=blodrftcfvyshh password=0516abc94ad85d3b4e126ff67eae2e73022401049d2862f853034cd2e5e37c61";
$con = pg_connect($con_string);

$isAuth = false;

function getUserName(){
	if(isset($_POST['email'])) {
	    $username = trim($_POST['email']);
	    $query = pg_query($con, "SELECT email, nome FROM usuario WHERE email='$username'");
		if(pg_num_rows($query) > 0){
			$row = pg_fetch_array($query);
			$isAuth = true;
			$nome=$row['nome'];
		}
	}
	 
	if($isAuth) {
		$response["success"] = 1;
		
		// codigo sql da sua consulta
		$response["data"] = $nome;
	}
	else {
		$response["success"] = 0;
		$response["error"] = "falha de autenticação";
	}
}

pg_close($con);
echo json_encode($response);
?>