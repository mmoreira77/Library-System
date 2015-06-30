<?php
include_once '../class/library.php';
$obj = new Marc();
$tipo_material = $obj->GetTipoMaterial();
?>

<div class="box box-success box-solid">
    <div class="box-header">
        <h3 class="panel-title" id="panel-title">Administrador de material item<a class="anchorjs-link" href="#panel-title"><span class="anchorjs-icon"></span></a></h3>
    </div>
    <div class="panel-body">            
        <div>
            <button class="btn btn-success add_tipo_material"><span class="glyphicon glyphicon-plus"></span>  Nuevo</button>
            <button class="btn btn-danger cancelar_tipo_material"><span class="glyphicon glyphicon-remove"></span>  Cancelar</button>
            <div class="new_tipo_material"></div>
        </div>
        <div class="box lista_tipo_material_marc">    

            <?php
            echo $tipo_material;
            ?>

        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.cancelar_tipo_material').hide();
        $('.add_tipo_material').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: 'app/marc/operaciones.php',
                data: {operacion: 0}, //Operacion igual cero llamar a formulario para ingreso de nuevo registo
                type: 'post',
                dataType: 'html',
                success: function (datos) {
                    $('.cancelar_tipo_material').show();
                    $('.new_tipo_material').html(datos)
                }
            });
        });
        $('.cancelar_tipo_material').click(function(){
            $('.new_tipo_material').html('');
            $('.cancelar_tipo_material').hide();
        });
    });
</script>

