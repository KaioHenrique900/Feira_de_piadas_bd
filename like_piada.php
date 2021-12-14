<?php
session_start();
// connecting to db
$con_string = "host=ec2-35-168-80-116.compute-1.amazonaws.com port=5432 dbname=d3cnre2oc9uli5 user=blodrftcfvyshh password=0516abc94ad85d3b4e126ff67eae2e73022401049d2862f853034cd2e5e37c61";
$con = pg_connect($con_string);

// array for JSON response
$response = array();

/*
$username=NULL;
//Método para mod_php (Apache)
if (isset( $_SERVER['PHP_AUTH_USER'] ) ) {
    $username = $_SERVER['PHP_AUTH_USER'];
}
// Método para demais servers
elseif(isset( $_SERVER['HTTP_AUTHORIZATION'])) {
    if(preg_match( '/^basic/i', $_SERVER['HTTP_AUTHORIZATION']))
		list($username, $password) = explode(':', base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));
}

// Se a autenticação não foi enviada
if(is_null($username)) {
    $response["success"] = 0;
	$response["error"] = "faltam parametros";
}*/


	if(isset($_POST['titlePiada'])){
		$username = trim($_POST['email']);
		$titlePiada = trim($_POST['titlePiada']);
		$query_userId=pg_query($con, "SELECT id_usuario FROM usuario WHERE email = '$username'");
		$query_piadaId=pg_query($con, "SELECT id_piada FROM piada WHERE titulo = '$titlePiada'");

		$userArray = pg_fetch_array($query_userId);
		$piadaArray = pg_fetch_array($query_piadaId);

		$userId = $userArray['id_usuario'];
		$piadaId =$piadaArray['id_piada'];

	    $query = pg_query($con, "INSERT INTO curte(fk_id_usuario, fk_id_piada) VALUES($userId, $piadaId)");

	    $response["success"]=1;
	}

else{
	$response["success"]=0;
	$response["error"]="Algo deu errado";
}


pg_close($con);
echo json_encode($response);

?>
