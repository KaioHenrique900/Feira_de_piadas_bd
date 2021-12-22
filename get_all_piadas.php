<?php
$response = array();

$con_string = "host=ec2-35-168-80-116.compute-1.amazonaws.com port=5432 dbname=d3cnre2oc9uli5 user=blodrftcfvyshh password=0516abc94ad85d3b4e126ff67eae2e73022401049d2862f853034cd2e5e37c61";
$con = pg_connect($con_string);

$queryPiadas = pg_query($con, "SELECT id_piada, descricao, data_publicacao, titulo FROM piada");

if (pg_num_rows($queryPiadas)>0){
	$response["piadas"] = array();
 
    while ($row = pg_fetch_array($queryPiadas)) {
        $piada = array();
        $piada["id_piada"] = $row["id_piada"];
        $piada["titulo"] = $row["titulo"];
        $piada["descricao"] = $row["descricao"];
        $piada["data_publicacao"] = $row["data_publicacao"];
	 
        array_push($response["piadas"], $piada);
    }
	$response["success"] = 1;
}

else{
	$response["success"] = 0;
	$response["error"] = "Algo está errado";
}

pg_close($con);
echo json_encode($response);

?>