<?php

class library {

    public function Conexion() {
        $link = mysql_connect('localhost', 'root', '191519') or die('Problemas en la conexión');
        $db = mysql_select_db('library', $link) or die('Problema en la selección de la base de datos');
        return $link;
    }

    public function GetCategory() {
        $query = 'select id,name,descripcion from category';
        $result = mysql_query($query, $this->Conexion());
        while ($row = mysql_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    }

    public function GetCategoryId($id = NULL) {
        $query = 'select id,name,descripcion from category where id = ' . $id;
        $result = mysql_query($query, $this->Conexion());
        while ($row = mysql_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    }
    
    //Buscar en etiquetas alguna categoria asiciada. Alerta no eliminacion
    public function SearchEtiqueta($id = NULL){
        
    }

    public function set_Categoria($nombre = NULL, $desscripcion = NULL) {
        $date_create = date('Y-m-d H:i:s');
        $date_modify = date('Y-m-d H:i:s');
        $query = 'insert into category (date_create,date_modify,name,descripcion) values ("' . $date_create . '","' . $date_modify . '","' . $nombre . '","' . $desscripcion . '")';
        $result = mysql_query($query, $this->Conexion());
        if ($result) {
            $operacion = 1; //exito en la inserción de los datos            
        } else {
            $operacion = 0;  //Error en la inserción de los datos
        }
        return $operacion;
    }

    //Actualizar categoria el nombre o descripción
    public function update_Categoria($id = NULL, $nombre = NULL, $descripcion = NULL) {
        $date_modify = date('Y-m-d H:i:s');
        $query = 'update category set date_modify = "' . $date_modify . '", name = "' . $nombre . '", descripcion = "' . $descripcion . '" where id = ' . $id;
        $result = mysql_query($query, $this->Conexion());
        if ($result) {
            $operacion = $id; //Exito en la actualizacion
        } else {
            $operacion = 0;  //Error en la actualización
        }
        return $operacion;
    }

    public function get_Tab() {
        $query = 'select a.nombre,a.descripcion,b.name as categoria, b.id from tab as a
                    inner join category as b
                    on a.id_category = b.id';
        $result = mysql_query($query, $this->Conexion());
        while ($row = mysql_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    }

    public function set_Tab($nombre = NULL, $descripcion = NULL, $id_categoria = NULL) {
        $date_create = date('Y-m-d H:i:s');
        $date_modify = date('Y-m-d H:i:s');
        $query = 'insert into tab (date_create,date_modify,nombre,descripcion,id_category) values ("' . $date_create . '","' . $date_modify . '","' . $nombre . '","' . $descripcion . '",' . $id_categoria . ')';
        $result = mysql_query($query, $this->Conexion());
        if ($result) {
            $operacion = 1; //exito en la inserción de los datos            
        } else {
            $operacion = 0;  //Error en la inserción de los datos
        }
        return $operacion;
    }

    //Borrando categorias que no esten asociados tadavia a ninguna etiqueta
    public function delete_Categoria($id = NULL) {
        $query = 'delete from category where id = ' . $id;
        $result = mysql_query($query);
        if ($result) {
            $operacion = '<h3>Operación de eliminacion registro ejecutado con exito.</h3>';
        } else {
            $operacion = '<h3>Operación de elinación no ejecutada.</h3>';
        }
        return $operacion;
    }

}
