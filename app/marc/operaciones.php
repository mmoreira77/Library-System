<?php
include_once '../class/library.php';
$obj = new Marc();

//Evaluacion de la variable operación para el retorno de la respuestas
//Cuando operecion igual cero retornar formulario de insercion de nuevo registro
if (isset($_REQUEST['operacion']) && $_REQUEST['operacion'] == 0) {
    include 'form_add_new_conten.php';
    }

//Operacion igual uno guardar registro de nuevo material con logo de imagen
    elseif (isset ($_REQUEST['operacion']) && $_REQUEST['operacion'] == 1) {
    $new_registro = $obj->SaveNewRegistro ($_POST, $_FILES);
    echo $new_registro;
    }

//Llenando modall para editar
    elseif (isset ($_REQUEST['operacion']) && $_REQUEST['operacion'] == 2) {
    $registro_item = $obj->GetItemId($_REQUEST['id']);
    include 'form_edit_conten.php';
}

//Uptualizando registro
    elseif (isset ($_REQUEST['operacion']) && $_REQUEST['operacion'] == 3) {
    $update_registro = $obj->UpdateRegistro($_POST, $_FILES);
    echo $update_registro;
}

//Obteniendo información antes de eliminar para modal
elseif (isset ($_REQUEST['operacion']) && $_REQUEST['operacion'] == 4) {
    $tipo_material = $obj->GetTipoMaterialID($_REQUEST['id']);
    echo '<pre>';
    print_r($tipo_material);
    echo '</pre>';
}

?>
