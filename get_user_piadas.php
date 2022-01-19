<?php
$response = array();

$con_string = "host=ec2-35-168-80-116.compute-1.amazonaws.com port=5432 dbname=d3cnre2oc9uli5 user=blodrftcfvyshh password=0516abc94ad85d3b4e126ff67eae2e73022401049d2862f853034cd2e5e37c61";
$con = pg_connect($con_string);

$id_usuario = trim($_POST['uid']);
/*$email = trim($_POST['email']);
$queryIdEmail = pg_query($con, "SELECT id_usuario WHERE email='$email'");
$id_usuario = pg_fetch_array($queryIdEmail);*/

$queryIdPiada = pg_query($con, "SELECT id_piada FROM piada WHERE fk_id_usuario = '$id_usuario'");

if (pg_num_rows($queryIdPiada)>0){
    $response["piadas"] = array();

    while ($row = pg_fetch_array($queryIdPiada)) {
        $id_piada = $row['id_piada'];

        $queryPiada = pg_query($con, "SELECT * FROM piada WHERE id_piada = $id_piada");
        $currentPiada = pg_fetch_array($queryPiada);

        $piada = array();
        $piada["id_piada"] = $currentPiada["id_piada"];
        $piada["titulo"] = $currentPiada["titulo"];
        $piada["descricao"] = $currentPiada["descricao"];
        $piada["data_publicacao"] = $currentPiada["data_publicacao"];
        $piada["id_usuario"] = $currentPiada['fk_id_usuario'];

        array_push($response["piadas"], $piada);
   }
	$response["success"] = 1;
}

else{
	$response["success"] = 0;
	$response["error"] = "Usuário não possui piadas";
}

pg_close($con);
echo json_encode($response);


?>