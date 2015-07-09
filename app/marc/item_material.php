<?php
include_once '../class/library.php';
$obj = new Marc();
$tipo_material = $obj->GetTipoMaterial();
?>

<div class="box-header">
    <button class="btn btn-info add_tipo_material"><span class="glyphicon glyphicon-plus"></span>  Nuevo Item</button>
    <button class="btn btn-danger cancelar_tipo_material"><span class="glyphicon glyphicon-remove"></span>  Cancelar</button>
    <div class="new_tipo_material"></div>
</div>

<div class="box box-success box-solid">
    <div class="box-header">
        <h3 class="panel-title" id="panel-title">Administrador de material item<a class="anchorjs-link" href="#panel-title"><span class="anchorjs-icon"></span></a></h3>
    </div>
    <div class="panel-body">
        <div class="box lista_tipo_material_marc">    

            <?php
            echo $tipo_material;
            ?>

        </div>
    </div>
</div>

<!--Inicio de modales-->
<!-- Modal EDITAR-->
<div class="modal modal-primary modal_item_editar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">EDITAR ITEM</h4>
            </div>
            <div class="modal-body body_item">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Cerrar</button>                    
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Fin de modal -->

<script>

    $('.cancelar_tipo_material').hide();
    
    $('.add_tipo_material').click(function (e) {
        e.preventDefault();
        $.ajax({
            url: 'app/marc/operaciones.php',
            data: {operacion: 0}, //Operacion igual cero llamar a formulario para ingreso de nuevo registo
            type: 'post',
            dataType: 'html',
        }).done(function (datos) {
            $('.new_tipo_material').html(datos);
            $('.cancelar_tipo_material').show();
        });
    });
    
    $('.new_tipo_material').on('click','.save_tipo_material',function (e) {
        e.preventDefault();
        var data_form_nuevo_material = new FormData($('.form_nuevo_material')[0]);
        $.ajax({
            url: 'app/marc/operaciones.php',
            type: 'post',
            data: data_form_nuevo_material,
            cache: false,
            contentType: false,
            processData: false
        }).done(function (datos) {
            $('.new_tipo_material').html('');
            $('.lista_tipo_material_marc').html(datos);
            $('.cancelar_tipo_material').hide();
        });
    });

    $('.body_principal').on('click', '.cancelar_tipo_material', function () {
        $('.new_tipo_material').html('');
        $('.cancelar_tipo_material').hide();
    });

    //Lamando modal para editar item
    $('.body_principal').on('click', '.edit_item_material', function () {
        var id_item = $(this).attr('id');
        $.ajax({
            url: 'app/marc/operaciones.php',
            type: 'post',
            data: {operacion: 2, id: id_item}
        }).done(function (datos) {
            $('.body_item').html(datos);

        });
        $('.modal_item_editar').modal();
    });


    $('.body_principal').on('click', '.apdate_tipo_material', function () {
        var data_form_nuevo_material = new FormData($('.form_edit_material')[0]);
        $.ajax({
            url: 'app/marc/operaciones.php',
            type: 'post',
            data: data_form_nuevo_material,
            cache: false,
            contentType: false,
            processData: false
        }).done(function (datos) {
            $('.new_tipo_material').html('');
            $('.lista_tipo_material_marc').html(datos);
            $('.cancelar_tipo_material').hide();
        });
    });

    $('.body_principal').on('change', '#InputFile', function (e) {
        e.preventDefault();

        var fileInput = document.getElementById('InputFile');
        var fileDisplayArea = document.getElementById('preview_icono');

        var file = fileInput.files[0];
        var imageType = /image.*/;

        if (file.type.match(imageType)) {
            var reader = new FileReader();

            reader.onload = function (e) {
                fileDisplayArea.innerHTML = "";

                var img = new Image();
                img.src = reader.result;

                fileDisplayArea.appendChild(img);
            }

            reader.readAsDataURL(file);
        } else {
            fileDisplayArea.innerHTML = "File not supported!";
        }

    });

</script>

