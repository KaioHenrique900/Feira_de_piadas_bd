<?php
 
/*
 * Following code will create a new product row
 * All product details are read from HTTP Post Request
 */
 
// connecting to db
$con_string = "host=ec2-35-168-80-116.compute-1.amazonaws.com port=5432 dbname=d3cnre2oc9uli5 user=blodrftcfvyshh password=0516abc94ad85d3b4e126ff67eae2e73022401049d2862f853034cd2e5e37c61";
$con = pg_connect($con_string);
 
// array for JSON response
$response = array();
 
// check for required fields
if (isset($_POST['newLogin']) && isset($_POST['newPassword']) && isset($_POST['newUser']) && isset($_POST['newDate'])) {
 
	$newLogin = trim($_POST['newLogin']);
	$newPassword = trim($_POST['newPassword']);
	$newUser = trim($_POST['newUser']);
	$newDate = trim($_POST['newDate']);
		
	$usuario_existe = pg_query($con, "SELECT login FROM usuario WHERE email='$newLogin'");
	// check for empty result
	if (pg_num_rows($usuario_existe) > 0) {
		$response["success"] = 0;
		$response["error"] = "Usuario ja cadastrado";
	}
	else {
		// mysql inserting a new row
		$result = pg_query($con, "INSERT INTO usuario(email, senha, nome, data_nasc) VALUES('$newLogin', '$newPassword', '$newUser', '$newDate')");
	 
		if ($result) {
			$response["success"] = 1;
		}
		else {
			$response["success"] = 0;
			$response["error"] = "Error BD: ".pg_last_error($con);
		}
	}
}
else {
    $response["success"] = 0;
	$response["error"] = "faltam parametros";
}

pg_close($con);
echo json_encode($response);
?>