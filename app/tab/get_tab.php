<?php
include_once '../class/library.php';
$obj = new library();
$tab  = new Tab();

//validando la variable operación si existe para proceder a guardar una nueva categoria
if (isset($_REQUEST['operacion']) && $_REQUEST['operacion'] == 2) {
    $set = $obj->set_Tab($_REQUEST['nombre'], $_REQUEST['descripcion'], $_REQUEST['categoria']);
}

//Comprobando que la operación sea 3 para sacar el texbox para edición 
elseif (isset($_REQUEST['operacion']) && $_REQUEST['operacion'] == 3) {
    $textbox = $obj->get_TabId($_REQUEST['id']);
    $html_edit = '<input type="text" class="form-control name_etiqueta" id_etiqueta_update = "' . $_REQUEST['id'] . '" value="' . $textbox[0]['nombre'] . '">'
            . '<input type="text" class="form-control descripcion_etiqueta" value="' . $textbox[0]['descripcion'] . '">';
    echo $html_edit;
}elseif (isset($_REQUEST['operacion']) && $_REQUEST['operacion'] == 4) {
    $operacion = $tab->update_Etiqueta($_REQUEST['id'], $_REQUEST['nombre'], $_REQUEST['descripcion']);
}else {

    $tab_show = $obj->get_Tab();

    $contador = 0;

    foreach ($tab_show as $key => $value) {
        $contador ++;
        $table_body.= '<tr>'
                . '<td>' . $contador . '</td><td>' . $value['nombre'] . '</td>'
                . '<td>' . $value['descripcion'] . '</td><td>' . $value['categoria'] . '</td>'
                . '<td>'
                . '<a href="#">'
                . '<i id="' . $value['id_etiq'] . '" class="fa fa-fw fa-pencil-square-o edit_etiqueta"></i>'
                . '<i id="' . $value['id_etiq'] . '" class="fa fa-fw fa-eraser delete_etiqueta"></i>'
                . '</a>'
                . '</td>'
                . '</tr>';
    }

    $categorias = $obj->GetCategory();
    foreach ($categorias as $key => $value) {
        $select_body.= '<option value="' . $value['id'] . '">' . $value['name'] . ' --> ' . $value['descripcion'] . '</option>';
    }
    $select = '<select class="form-control select_categoria">'
            . '<option>Selecione categoría</option>'
            . $select_body .
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
                    <thead><tr><th>#</th><th>Etiqueta</th><th>Descripción</th><th>Categoria</th><th>Edición</th></tr></thead>
                    <?php echo $table_body; ?>
                </table>
            </div>
        </div>
    </div>

    <!-- Inicio de modal EDITAR-->
    <div class="modal modal-primary modal_etiqueta">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">EDITAR ETIQUETA</h4>
                </div>
                <div class="modal-body body_etiqueta">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-outline up_etiqueta">Guardar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- Fin de modal -->

    <!-- Inicio de modal para DELETE-->
    <div class="modal modal-danger modal_etiqueta_delete">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">ELIMINAR ETIQUETA</h4>
                </div>
                <div class="modal-body delete_category_modal">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-outline up_delete_etiqueta">Eliminar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- Fin de modal -->

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
                    data: {nombre: nombre_etiqueta, descripcion: etiqueta_descrip, categoria: categoria, operacion: operacion},
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

        //Mostrar modal para editar etiqueta
        $('.edit_etiqueta').click(function (e) {
            e.preventDefault();
            var id = $(this).attr('id');
            var operacion = 3; //codigo para obtener la información en un texbox para edición
            $.ajax({
                url: 'app/tab/get_tab.php',
                data: {id: id, operacion: operacion},
                type: 'post',
                dataType: 'html',
                success: function (datos) {
                    $('.body_etiqueta').html(datos);
                }
            });
            $('.modal_etiqueta').modal();
        });
        
        //Tomando valores de los texbox que describen el nombre de la etiqueta y la descripción
        $('.up_etiqueta').click(function(e){
            e.preventDefault();
            var id = $('.name_etiqueta').attr('id_etiqueta_update');
            var data = $('.name_etiqueta').val();
            var descrip_data = $('.descripcion_etiqueta').val();
            var operacion = 4;  //Valor para identificar que se actualizara el nombre de la etiqueta o la descripcion
            $.ajax({
                url: 'app/tab/get_tab.php',
                data: {id: id, operacion: operacion, nombre:data, descripcion:descrip_data},
                type: 'post',
                dataType: 'html',
                success: function (datos) {
                    $.ajax({
                        url: 'app/tab/get_tab.php',
                        type: 'post',
                        dataType: 'html',
                        success: function(datos){
                            $('.body_principal').html(datos);
                        }
                    });
                }
            });
        });
        
        //Mostrar modal para confirmación de eliminación
            $('.delete_etiqueta').click(function (e) {
                e.preventDefault();
                var id = $(this).attr('id');
                var operacion = 'delete'; //codigo para obtener la información en un texbox para edición
                $.ajax({
                    url: 'app/tab/get_tab.php',
                    data: {id: id, operacion: operacion},
                    type: 'post',
                    dataType: 'html',
                    success: function (datos) {
                        $('.delete_etiqueta_modal').html(datos);
                    }
                });
                $('.modal_etiqueta_delete').modal();
            });
        
        //Llamada para eliminar etiqueta
            $('.up_delete_etiqueta').click(function (e) {
                e.preventDefault();
                var id_etiqueta = $('.name_etiqueta').attr('id_etiqueta_update');
                var operacion = 'confir_delete';
                $.ajax({
                    url: 'app/tab/get_tab.php',
                    data: {id: id_etiqueta, operacion: operacion},
                    type: 'post',
                    dataType: 'html',
                    success: function (datos) {
                        $('.body_principal').html(datos);
                    }
                });
            });

    });
</script>

<?php
}
?>
