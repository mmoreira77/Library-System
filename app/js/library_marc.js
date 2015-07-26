
$('.body_principal').on('click', '.save_tipo_material', function (e) {
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

$('.body_principal').on('click', '.cancelar_tipo_material', function (e) {
    e.preventDefault();
    $('.new_tipo_material').html('');
    $('.cancelar_tipo_material').hide();
});

//Lamando modal para editar item
$('.body_principal').on('click', '.edit_item_material', function (e) {
    e.preventDefault();
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


$('.body_principal').on('click', '.apdate_tipo_material', function (e) {
    e.preventDefault();
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

//Llamada a modal para eliminar material
$('.body_principal').on('click', '.delete_item_material', function (e) {
    e.preventDefault();    
    var id = $(this).attr('id');
    $.ajax({
        url: 'app/marc/operaciones.php',
        type: 'post',
        data: {operacion:4,id:id}
    }).done(function(datos){
        $('.delete_itemmarc_modal').html(datos);
        $('.modal_item_material_delete').modal();
    });
    
});