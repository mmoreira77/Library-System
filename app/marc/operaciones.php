<?php
include_once '../class/library.php';
$obj = new Marc();

//Evaluacion de la variable operación para el retorno de la respuestas
//Cuando operecion igual cero retornar formulario de insercion de nuevo registro
if (isset($_REQUEST['operacion']) && $_REQUEST['operacion'] == 0) {
    $form_insert = '<div class="box box-primary">
                <div class="box-header">
                  <h3 class="box-title">Registro para tipo de material</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" class="form_nuevo_material" enctype="multipart/form-data">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="InputNameTipoMaterial">Nombre de tipo de material</label>
                      <input type="text" class="form-control" id="InputNameTipoMaterial" name="InputNameTipoMaterial" placeholder="Nuevo tipo de material">
                    </div>
                    <div class="form-group">
                      <label for="InputDescripcion">Descripción</label>
                      <input type="text" class="form-control" id="InputDescripcion" name="InputDescripcion" placeholder="Descripción">
                    </div>
                    <div class="form-group">
                      <label for="InputFile">Icono imagen</label>
                      <input type="file" id="InputFile" name="InputFile">
                    </div>               
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="button" class="btn btn-primary btn-block save_tipo_material">Guardar</button>
                  </div>
                  <input type="hidden" name="operacion" value="1">
                </form>
              </div>';
    echo $form_insert;
}

//Operacion igual uno guardar registro de nuevo material
    elseif (isset($_REQUEST['operacion']) && $_REQUEST['operacion'] == 1) {
        print_r($_REQUEST);
}
?>
<script>
    $(document).ready(function () {
        /* $('.save_tipo_material').click(function (e) {
            var nombre_tipo = $('#InputNameTipoMaterial').val();
            var descripcion_tipo = $('#InputDescripcion').val();
            alert(nombre_tipo + ' ' + descripcion_tipo);
        }); */

        $('.save_tipo_material').click(function () {            
            var data_form_nuevo_material = new FormData($('.form_nuevo_material')[0]);
            $.ajax({
                url: 'app/marc/operaciones.php',
                type: 'post',
                data: data_form_nuevo_material,
                cache: false,
                contentType: false,
                processData: false
            }).done(function(datos){
                $('.new_tipo_material').html(datos);
            });
        });
    });
</script>

