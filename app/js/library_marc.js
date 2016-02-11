
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
//        $('.cancelar_tipo_material').hide();
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
        data: {operacion: 4, id: id}
    }).done(function (datos) {
        $('.delete_itemmarc_modal').html(datos);
        //Ocultado o mostrando botton para eliminar o deshabilitar
        if ($('.id_tipo_material_delete').length > 0) {
            $('.up_delete_material').show();
            $('.up_deshabilitar_material').hide();
        } else {
            $('.up_delete_material').hide();
            $('.up_deshabilitar_material').show();
        }
        //Ocultando botton deshabilirar si ya esta deshabilitado
        if ($('.bandera_btn_deshabilitar').length > 0) {
            $('.up_deshabilitar_material').hide();
        }
        $('.modal_item_material_delete').modal();
    });

});

//Ejecutando eliminacion
$('.body_principal').on('click', '.up_delete_material', function (e) {
    e.preventDefault();
    var id_tipo_material = $('.id_tipo_material_delete').attr('id_tipo_material_delete');
    $.ajax({
        url: 'app/marc/operaciones.php',
        type: 'post',
        data: {id: id_tipo_material, operacion: 5}
    }).done(function (datos) {
        $('.lista_tipo_material_marc').html(datos);
    });
});

//Ejecutando deshabilitación de registro
$('.body_principal').on('click', '.up_deshabilitar_material', function (e) {
    e.preventDefault();
    var id_tipo_material = $('.id_tipo_material_deshabilitar').attr('id_tipo_material_deshabilitar');
    $.ajax({
        url: 'app/marc/operaciones.php',
        type: 'post',
        data: {id: id_tipo_material, operacion: 6}
    }).done(function (datos) {
        $('.lista_tipo_material_marc').html(datos);
    });
});

//Cambiando estado de tipo de material
$('.body_principal').on('click', '.change_visibility', function (e) {
    e.preventDefault();
    var stado_actual = $(this).attr('stado');
    var id = $(this).attr('id');
    if (stado_actual === '1') {
        var stado = '';
    }
    if (stado_actual === 'NULL') {
        stado = 1;
    }
    $.ajax({
        url: 'app/marc/operaciones.php',
        type: 'post',
        data: {stado: stado, id: id, operacion: 7}
    }).done(function (datos) {
        $('.lista_tipo_material_marc').html(datos);
    });
});

