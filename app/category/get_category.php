<?php
include_once '../class/library.php';
$obj = new library();

//validando la variable operación si existe para proceder a guardar una nueva categoria
if (isset($_REQUEST['operacion']) && $_REQUEST['operacion'] == 1) {
    $set = $obj->set_Categoria($_REQUEST['nombre'], $_REQUEST['descripcion']);
}

//Comprobando que la operación sea 3 para sacar el texbox para edición 
if (isset($_REQUEST['operacion']) && $_REQUEST['operacion'] == 3) {
    $textbox = $obj->GetCategoryId($_REQUEST['id']);
    $html_edit = '<input type="text" class="form-control name_category" id_category_update = "' . $_REQUEST['id'] . '" value="' . $textbox[0]['name'] . '">'
            . '<input type="text" class="form-control descripcion_category" value="' . $textbox[0]['descripcion'] . '">';
    echo $html_edit;
}
//Delete
elseif (isset($_REQUEST['operacion']) && $_REQUEST['operacion'] == 'delete') {
    $textbox = $obj->GetCategoryId($_REQUEST['id']);
    $mess_elim = $obj->SearchEtiqueta($_REQUEST['id']);
    if ($mess_elim === 0) {
        $html_edit.= '<input type="text" class="form-control name_category" id_category_update = "' . $_REQUEST['id'] . '" value="' . $textbox[0]['name'] . '" disabled>'
                . '<input type="text" class="form-control descripcion_category" value="' . $textbox[0]['descripcion'] . '" disabled>';
        $disabled = '<script>'
                . '$(document).ready(function(){'
                . '$(".up_delete_category").show();'
                . '});'
                . '</script>';
    } else {
        $html_edit = '<h3>' . $textbox[0]['name'] . '</h3>' . $mess_elim;
        $disabled = '<script>'
                . '$(document).ready(function(){'
                . '$(".up_delete_category").hide();'
                . '});'
                . '</script>';
    }
    echo $disabled . $html_edit;
} else {

    if (isset($_REQUEST['operacion']) && $_REQUEST['operacion'] == 'confir_delete') {
        $delete_categoria = $obj->delete_CategoriaConfir($_REQUEST['id']);        
    }

    $categorias = $obj->GetCategory();

    $contador = 0;
    foreach ($categorias as $key => $value) {
        $contador++;
        $table_body.= '<tr>'
                . '<td>' . $contador . '</td>'
                . '<td class="text-center">' . $value['name'] . '</td>'
                . '<td>' . $value['descripcion'] . '</td>'
                . '<td>'
                . '<a href="#">'
                . '<i id="' . $value['id'] . '" class="fa fa-fw fa-pencil-square-o edit_category"></i>'
                . '<i id="' . $value['id'] . '" class="fa fa-fw fa-eraser delete_category"></i>'
                . '</a>'
                . '</td>'
                . '</tr>';
    }
    ?>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title" id="panel-title">Administrador de categorias<a class="anchorjs-link" href="#panel-title"><span class="anchorjs-icon"></span></a></h3>
        </div>
        <div class="panel-body">            
            <div>
                <button class="btn btn-success add_categoria"><span class="glyphicon glyphicon-plus"></span>  Nueva Categoria</button>
                <button class="btn btn-danger cancelar_categoria"><span class="glyphicon glyphicon-remove"></span>  Cancelar</button>
                <div class="new_categoria"></div>
            </div>
            <div class="box">    
                <table class="table table-bordered text-center">
                    <thead><tr><th>#</th><th>Categoria</th><th>Descripción</th><th>Edición</th></tr></thead>
                    <?php echo $table_body; ?>
                </table>
            </div>
        </div>
    </div>

    <!-- Inicio de modal EDITAR-->
    <div class="modal modal-primary modal_category">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">EDITAR CATEGORÍA</h4>
                </div>
                <div class="modal-body body_category">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-outline up_category">Guardar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- Fin de modal -->

    <!-- Inicio de modal para DELETE-->
    <div class="modal modal-danger modal_category_delete">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">ELIMINAR CATEGORÍA</h4>
                </div>
                <div class="modal-body delete_category_modal">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-outline up_delete_category">Eliminar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- Fin de modal -->

    <script>
        $(document).ready(function () {
            $('.cancelar_categoria').hide();

            //Muestra formulario oculto para agregar categorias
            $('.add_categoria').click(function () {
                $('.new_categoria').html('<hr><input type="text" class="form-control name_categoria" placeholder="Nombre categoria"><input type="text" class="form-control categoria_descrip" placeholder="Descripción"><button class="btn btn-block btn-primary btn-lg save_categoria">Guardar</button><hr>');
                $('.cancelar_categoria').show();
                $('.save_categoria').click(function () {
                    var nombre_categoria = $('.name_categoria').val();
                    var categoria_descrip = $('.categoria_descrip').val();
                    var operacion = 1;  //Este valor sera para identificar que va ingresar una nueva categoria
                    $.ajax({
                        url: 'app/category/get_category.php',
                        data: {nombre: nombre_categoria, descripcion: categoria_descrip, operacion: operacion},
                        type: 'post',
                        dataType: 'html',
                        success: function (datos) {
                            $('.body_principal').html(datos);
                        }
                    });
                });
            });

            //Ocultar las formulario para ingresar categorias
            $('.cancelar_categoria').click(function () {
                $('.new_categoria').html('');
                $('.cancelar_categoria').hide();
            });

            //Mostrar modal para editar categoría
            $('.edit_category').click(function (e) {
                e.preventDefault();
                var id = $(this).attr('id');
                var operacion = 3; //codigo para obtener la información en un texbox para edición
                $.ajax({
                    url: 'app/category/get_category.php',
                    data: {id: id, operacion: operacion},
                    type: 'post',
                    dataType: 'html',
                    success: function (datos) {
                        $('.body_category').html(datos);
                    }
                });
                $('.modal_category').modal();
            });

            //Mostrar modal para confirmación de eliminación
            $('.delete_category').click(function (e) {
                e.preventDefault();
                var id = $(this).attr('id');
                var operacion = 'delete'; //codigo para obtener la información en un texbox para edición
                $.ajax({
                    url: 'app/category/get_category.php',
                    data: {id: id, operacion: operacion},
                    type: 'post',
                    dataType: 'html',
                    success: function (datos) {
                        $('.delete_category_modal').html(datos);
                    }
                });
                $('.modal_category_delete').modal();
            });

            //Tomando los datos de la modal para edicion
            $('.up_category').click(function (e) {
                e.preventDefault();
                var categoria = $('.name_category').val();
                var id_categoria = $('.name_category').attr('id_category_update');
                var descripcion = $('.descripcion_category').val();
                $.ajax({
                    url: 'app/category/set_category.php',
                    data: {id: id_categoria, categoria: categoria, descripcion: descripcion},
                    type: 'post',
                    dataType: 'html',
                    success: function (datos) {
                        $.ajax({
                            url: 'app/category/get_category.php',
                            type: 'post',
                            dataType: 'html',
                            success: function (data) {
                                $('.body_principal').html(data);
                            }
                        });
                    }
                });
            });

            //Llamada para eliminar
            $('.up_delete_category').click(function (e) {
                e.preventDefault();
                var id_category = $('.name_category').attr('id_category_update');
                var operacion = 'confir_delete';
                $.ajax({
                    url: 'app/category/get_category.php',
                    data: {id: id_category, operacion: operacion},
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
