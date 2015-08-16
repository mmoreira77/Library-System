<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">Confirmación para eliminar registros</h3>
    </div>    
    <div class="box-body">
        <dl>
            <dt class="text-black">Nombre de tipo de material: </dt>
            <dd class="text-danger id_tipo_material_delete" id_tipo_material_delete="<?php echo $tipo_material['id']; ?>"><?php echo $tipo_material['name']; ?></dd>
            <hr>
            <dt class="text-black">Descripción: </dt>
            <dd class="text-danger"><?php echo $tipo_material['descripcion']; ?></dd>
            <hr>
            <dt class="text-black">Icono representativo:</dt>
            <dd><img src="app/img/<?php echo $tipo_material['icono']; ?>" ></dd>
        </dl>        
    </div>
</div>
