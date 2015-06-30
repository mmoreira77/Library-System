<?php
include_once '../class/library.php';
$obj = new Marc();

//Evaluacion de la variable operación para el retorno de la respuestas
//Cuando operecion igual cero retornar formulario de insercion de nuevo registro
if (isset($_REQUEST['operacion']) && $_REQUEST['operacion'] == 0) {
    include 'form_add_new_conten.php';
}

//Operacion igual uno guardar registro de nuevo material con logo de imagen
elseif (isset($_REQUEST['operacion']) && $_REQUEST['operacion'] == 1) {
    $new_registro = $obj->SaveNewRegistro($_POST, $_FILES);
    echo $new_registro;
}
?>
<script>
    $(document).ready(function () {
        $('.save_tipo_material').click(function () {            
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
            });
        });
        $('.form_nuevo_material').on('change','#InputFile', function(e){
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
    });
</script>

