<div class="box box-primary">
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
            <div class="form-group col-lg-6">
                <label for="InputFile">Icono imagen</label>
                <input type="file" class="form-control" id="InputFile" name="InputFile">
            </div>
            <div class="form-group col-lg-6">
                <label for="">Display icono</label>
                <div class="form-control" id="preview_icono"></div>
            </div>
        </div><!-- /.box-body -->

        <div class="box-footer">
            <button type="button" class="btn btn-primary btn-block save_tipo_material">Guardar</button>
        </div>
        <input type="hidden" name="operacion" value="1">
    </form>
</div>
