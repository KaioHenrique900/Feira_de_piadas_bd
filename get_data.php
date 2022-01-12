<?php

session_start();

$response = array();

$con_string = "host=ec2-35-168-80-116.compute-1.amazonaws.com port=5432 dbname=d3cnre2oc9uli5 user=blodrftcfvyshh password=0516abc94ad85d3b4e126ff67eae2e73022401049d2862f853034cd2e5e37c61";
$con = pg_connect($con_string);

$isAuth = false;

if(isset($_POST['email'])) {
    $username = trim($_POST['email']);
    $query = pg_query($con, "SELECT id_usuario, email, nome FROM usuario WHERE email='$username'");
	if(pg_num_rows($query) > 0){
		$row = pg_fetch_array($query);
		$isAuth = true;
		$nome=$row['nome'];
		$id_usuario=$row['id_usuario'];
	}
}
	 
if($isAuth) {
	$response["success"] = 1;
		
	$response["data"] = $nome;

	$response["id_usuario"] = $id_usuario;
}
else {
	$response["success"] = 0;
	$response["error"] = "falha de autenticação";
}

pg_close($con);
echo json_encode($response);

?>