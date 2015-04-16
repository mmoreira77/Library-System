<?php

include_once '../class/library.php';
$obj = new library();

$set = $obj->set_Categoria($_REQUEST['nombre'], $_REQUEST['descripcion']);

echo $set;

