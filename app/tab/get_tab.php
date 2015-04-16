<?php

include_once '../class/library.php';
$obj = new library();

//validando la variable operación si existe para proceder a guardar una nueva categoria
if (isset($_REQUEST['operacion']) && $_REQUEST['operacion'] == 2) {
    $set = $obj->set_Tab($_REQUEST['nombre'], $_REQUEST['descripcion'], $_REQUEST['categoria']);
}

$tab_show = $obj->get_Tab();

$contador = 0;

foreach ($tab_show as $key => $value) {
    $contador ++;
    $table_body.= '<tr><td>'.$contador.'</td><td>'.$value['nombre'].'</td><td>'.$value['descripcion'].'</td><td>'.$value['categoria'].'</td></tr>';
}

$categorias = $obj->GetCategory();
foreach ($categorias as $key => $value) {
    $select_body.= '<option value="'.$value['id'].'">'.$value['name'].' --> '.$value['descripcion'].'</option>';
}
$select = '<select class="form-control select_categoria">'
        . '<option>Selecione categoría 16042015</option>'
        . $select_body.
        '</select>';
?>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title" id="panel-title">Administrador de etiquetas<a class="anchorjs-link" href="#panel-title"><span class="anchorjs-icon"></span></a></h3>
    </div>
    <div class="panel-body"> 
        <div>
            <button class="btn btn-success add_etiqueta"><span class="glyphicon glyphicon-plus"></span>  Nueva Etiqueta</button>
            <button class="btn btn-danger cancelar_etiqueta"><span class="glyphicon glyphicon-remove"></span>  Cancelar</button>
            <div class="new_etiqueta"></div>
        </div>
        <div class="box">    
            <table class="table table-bordered text-center">
                <thead><tr><th>#</th><th>Etiqueta</th><th>Descripción</th><th>Categoria</th></tr></thead>
                <?php echo $table_body; ?>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.cancelar_etiqueta').hide();

        $('.add_etiqueta').click(function () {
            $('.new_etiqueta').html('<hr><input type="text" class="form-control name_etiqueta" placeholder="Nombre etiqueta"><input type="text" class="form-control etiqueta_descrip" placeholder="Descripción"><?php echo $select; ?><button class="btn btn-block btn-primary btn-lg save_etiqueta">Guardar</button><hr>');
            $('.cancelar_etiqueta').show();
            $('.save_etiqueta').click(function () {
                var nombre_etiqueta = $('.name_etiqueta').val();
                var etiqueta_descrip = $('.etiqueta_descrip').val();
                var categoria = $('.select_categoria').val();
                var operacion = 2;  //Este valor sera para identificar que va ingresar una nueva etiqueta
                $.ajax({
                    url: 'app/tab/get_tab.php',
                    data: {nombre: nombre_etiqueta, descripcion: etiqueta_descrip, categoria:categoria, operacion: operacion},
                    type: 'post',
                    dataType: 'html',
                    success: function (datos) {
                        $('.body_principal').html(datos);
                    }
                });
            });
        });

        $('.cancelar_etiqueta').click(function () {
            $('.new_etiqueta').html('');
            $('.cancelar_etiqueta').hide();
        });

    });
</script>