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

$queryTopPiadasIds = "SELECT fk_id_piada, COUNT(fk_id_piada) FROM curte GROUP BY fk_id_piada HAVING COUNT(fk_id_piada) > 0 ORDER BY COUNT(fk_id_piada) DESC LIMIT 10";

$resultPiadasCurtidasIds = pg_query($con, $queryTopPiadasIds);

if (pg_num_rows($resultPiadasCurtidasIds)>0){

	$response["topPiadas"] = Array();

	while ($row = pg_fetch_array($resultPiadasCurtidasIds)){

		$queryTopPiadas = pg_query($con, "SELECT p.id_piada, p.titulo, p.descricao, p.data_publicacao, p.fk_id_usuario, u.nome FROM piada as p join usuario as u on p.fk_id_usuario = u.id_usuario");
		$result = pg_fetch_array($queryTopPiadas);

        $piada = array();
        $piada["id_piada"] = $result["id_piada"];
        $piada["titulo"] = $result["titulo"];
        $piada["descricao"] = $result["descricao"];
        $piada["data_publicacao"] = $result["data_publicacao"];
        $piada["id_usuario"] = $result['fk_id_usuario'];
        $piada["nome_usuario"] = $result['nome'];
        $piada["likes"] = $row['COUNT(fk_id_piada)'];

        array_push($response["topPiadas"], $piada);
	}
	$response["success"]=1;
}

else{
	$response["success"]=0;
	$response["error"]="Algo deu errado";
}


pg_close($con);
echo json_encode($response);

?>
