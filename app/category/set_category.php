<?php

include_once '../class/library.php';
$obj = new library();
//Comprobando si la operacion es para ingresar una categoria nueva o actulizar una ya existente
if (isset($_REQUEST[id])) {
    $set = $obj->update_Categoria($_REQUEST['id'], $_REQUEST['categoria'], $_REQUEST['descripcion']);
}  else {
    $set = $obj->set_Categoria($_REQUEST['nombre'], $_REQUEST['descripcion']);
}
echo $set;

