<?php
header('Content-Type:application/json');

session_start();

//Obtener y decodificar los datos (DATA) que se envia por AjaxRequest
$data= json_decode(file_get_contents("php://input"),true)[0];

echo json_encode($data);
?>