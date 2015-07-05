<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">Registro para tipo de material</h3>
    </div><!-- /.box-header -->
    <!-- form start -->
    <form role="form" class="form_edit_material" style="color: black;" enctype="multipart/form-data">
        <div class="box-body">
            <div class="form-group">
                <label for="InputNameTipoMaterial">Nombre de tipo de material</label>
                <input type="text" value="<?php echo $registro_item['name']?>" class="form-control" id="InputNameTipoMaterial" name="InputNameTipoMaterial" placeholder="Nuevo tipo de material">
            </div>
            <div class="form-group">                
                <label for="InputDescripcion">Descripción</label>
                <input type="text" value="<?php echo $registro_item['descripcion'] ?>" class="form-control" id="InputDescripcion" name="InputDescripcion" placeholder="Descripción">
            </div>
            <div class="form-group col-lg-6">                
                <label for="InputFile">Icono imagen</label>
                <input type="file" class="form-control" id="InputFile" name="InputFile">
            </div>
            <div class="form-group col-lg-6">
                
                <label for="Icono">Display icono</label>
                <div class="" id="preview_icono"><img src="app/img/<?php echo $registro_item['icono'] ?>"></div>
            </div>
        </div><!-- /.box-body -->

        <div class="box-footer">
            <button type="button" class="btn btn-primary btn-block apdate_tipo_material" data-dismiss="modal">Guardar</button>
        </div>
        <input type="hidden" name="operacion" value="3">
        <input type="hidden" name="id" value="<?php echo $registro_item['id']; ?>">
    </form>
</div>
