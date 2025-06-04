<?php
header('Content-Type:application/json');

session_start();

//Obtener y decodificar los datos (DATA) que se envia por AjaxRequest
$data = json_decode(file_get_contents("php://input"), true)[0];

//Conexión a la bd
$con = new mysqli('localhost', 'root', '', 'tiendautrm');

//Consulta 
$query = "Update users SET visible=? where id=?";

$stmt = $con->prepare($query);

$vs = ($data['vs'] ? 0 : 1);

//Vincula los datos con los parametros de la consulta
$stmt->bind_param('ii', $vs, $data['id']);

//ejecutamos la consulta
if ($stmt->execute()) {
    $respuesta = array('respuesta' => '1', 'id' => $data['id'], 'vs' => $vs);
} else {
    $respuesta = array('respuesta' => '2', 'msg' => 'No tiene privilegios para esta operación');
}

$stmt->close();
$con->close();

echo json_encode($respuesta);
