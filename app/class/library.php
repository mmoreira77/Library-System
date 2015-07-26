<?php

class Conexion {

    public function Conexion() {
        $link = mysql_connect('localhost', 'root', '191519') or die('Problemas en la conexión');
        $db = mysql_select_db('library', $link) or die('Problema en la selección de la base de datos');
        return $link;
    }
    
    public function ConexionPDO(){
        try {
            $link = new PDO('mysql:host=localhost;dbname=library','root','191519');
        }
        catch (PDOException $ex) {
            echo "Sucedio un problema al realizar la conexión !!";
            exit;
        }
        return $link;
    }

}

class library extends Conexion {

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

    //Buscar en etiquetas alguna categoria asociada. Alerta no eliminacion
    public function SearchEtiqueta($id_categoria = NULL) {
        $query = 'select count(id_category) as num from tab where id_category = ' . $id_categoria;
        $result = mysql_query($query, $this->Conexion());
        if ($result) {
            $valor = mysql_fetch_assoc($result);
            if ($valor['num'] > 0) {
                $etiquetas = $this->GetEtiquetaNomre($id_categoria);
                $operacion = '<h2>Esta categoría no se puede eliminar, esta asignada a las siguientes etiquetas: </h2><h4>' . $etiquetas . '</h4>';
            } else {
                $operacion = 0;
            }
        }
        return $operacion;
    }

    //Obteniendo las etiquetas asignadas a una categoria
    public function GetEtiquetaNomre($id_categoria = NULL) {
        $query = 'select nombre from tab where id_category = ' . $id_categoria;
        $result = mysql_query($query, $this->Conexion());
        if ($result) {
            while ($row = mysql_fetch_assoc($result)) {
                $etiqueta.= $row['nombre'] . ',';
            }
        }
        return $etiqueta;
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
        $query = 'select a.id as id_etiq, a.nombre,a.descripcion,b.name as categoria, b.id from tab as a
                    inner join category as b
                    on a.id_category = b.id';
        $result = mysql_query($query, $this->Conexion());
        while ($row = mysql_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    }

    public function get_TabId($id_etiqueta = NULL) {
        $query = 'select a.id as id_etiq, a.nombre,a.descripcion,b.name as categoria, b.id from tab as a
                    inner join category as b
                    on a.id_category = b.id and a.id = ' . $id_etiqueta;
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

    //Eliminando categoria
    public function delete_CategoriaConfir($id_categoria = NULL) {
        $query = 'delete from category where id = ' . $id_categoria;
        $result = mysql_query($query, $this->Conexion());
        if ($result) {
            $operacion = '<small>Categoria eliminada</small>';
        } else {
            $operacion = '<small>Categoria no eliminada</small>';
        }
        return $operacion;
    }

}

//Definiendo clase para trabajar con etiquetas
class Tab extends library {

    //Actualizar etiqueta el nombre o descripción
    public function update_Etiqueta($id = NULL, $nombre = NULL, $descripcion = NULL) {
        $date_modify = date('Y-m-d H:i:s');
        $query = 'update tab set date_modify = "' . $date_modify . '", nombre = "' . $nombre . '", descripcion = "' . $descripcion . '" where id = ' . $id;
        $result = mysql_query($query, $this->Conexion());
        if ($result) {
            $operacion = $id; //Exito en la actualizacion
        } else {
            $operacion = 0;  //Error en la actualización
        }
        return $operacion;
    }

    //Obteniendo etiqueta a eliminar con la categoria pegada
    public function GetEtiquetaId($id = NULL) {
        $query = 'select a.nombre, a.descripcion, b.name as category
                    from tab as a 
                    inner join category as b
                    on a.id_category = b.id
                    where 
                    a.id = ' . $id;
        $result = mysql_query($query, $this->Conexion());
        while ($row = mysql_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    }

    //Eliminando etiqueta
    public function delete_EtiquetaConfir($id = NULL) {
        $query = 'delete from tab where id = ' . $id;
        $result = mysql_query($query, $this->Conexion());
        if ($result) {
            $operacion = '<small>Etiqueta eliminada</small>';
        } else {
            $operacion = '<small>Etiqueta no eliminada</small>';
        }
        return $operacion;
    }

}

//Definiendo clase para trabajar con marc
class Marc extends library {
    
    private $conx_pdo;


    public function __construct() {
        $this->conx_pdo = parent::ConexionPDO();
    }

    //Llamada a todos los tipos de material existentes
    public function GetTipoMaterial() {
        $query = 'select id,name,descripcion,icono from lib_tipo_material';
        $result = mysql_query($query, $this->Conexion());
        if ($result) {
            while ($row = mysql_fetch_assoc($result)) {
                $data[] = $row;
            }
            $table = $this->OrdenarTipoMaterial($data);
        }
        return $table;
    }
    
    //Llamada a tipo de material por id
    public function GetTipoMaterialID($id = NULL) {
        echo $id;
        echo '<br>';        
        $sql = 'select id,name,descripcion,icono from lib_tipo_material where  id = ?';
        $stm = $this->conx_pdo->prepare($sql);
        $stm->execute(array($id));
        $data = $stm->fetchAll(PDO::FETCH_ASSOC);        
        return $data;
    }

    //Ordeando tipo de material
    public function OrdenarTipoMaterial($data = NULL) {
        $contador = 0;
        foreach ($data as $key => $value) {
            $contador++;
            $table_body.= '<tr><td>' . $contador . '</td><td><img src="app/img/' . $value['icono'] . '"/></td><td>' . $value['name'] . '</td>'
                    . '<td>' . $value['descripcion'] . '</td><td>'
                    . '<i class="fa fa-fw fa-pencil-square-o edit_item_material" id="' . $value['id'] . '"></i>'
                    . '<i class="fa fa-fw fa-eraser delete_item_material" id="' . $value['id'] . '"></i></td></tr>';
        }
        $table = '<table class="table table-bordered text-center">
                <thead><tr><th>#</th><th>Icono</th><th>Material</th><th>Descripción</th><th>Edición</th></tr></thead>';
        $table_fin = '</table>';
        return $table . $table_body . $table_fin;
    }

    //Llamando a un item especifico
    public function GetItemId($id = NULL) {
        $query = 'select id,name,descripcion,icono from lib_tipo_material where id = ' . $id;
        $result = mysql_query($query, $this->Conexion());
        $row = mysql_fetch_assoc($result);
        return $row;
    }

    //Preparando para guardar nuevo registro. Desfragmentando información de la imagen
    public function SaveNewRegistro($data_post = NULL, $data_file = NULL) {
        if (count($data_file) > 0 && count($data_post) > 0) {
            $ruta_img = '../img/';
            foreach ($data_file as $value) {
                //Verificando que no existan errores en el envio del archivo
                if ($value['error'] == UPLOAD_ERR_OK) {
                    $file_name = $value['name'];
                    $file_tmp_name = $value['tmp_name'];
                    $ruta_final = $ruta_img . $file_name;
                    $result = move_uploaded_file($file_tmp_name, $ruta_final);
                    if ($result) {
                        $query = 'INSERT INTO lib_tipo_material (name, descripcion, icono, date_create, date_modify) '
                                . ' values("' . $data_post['InputNameTipoMaterial'] . '", "' . $data_post['InputDescripcion'] . '",'
                                . '"' . $file_name . '", "' . date('Y-m-d H:i:s') . '", "' . date('Y-m-d H:i:s') . '")';
                        $exec = mysql_query($query, $this->Conexion());
                        if ($exec) {
                            $ope = $this->GetTipoMaterial();
                        } else {
                            $ope = '<h4>Error en la insercion del registro</h4>';
                        }
                    } else {
                        $ope = 'Operación de subir archivo con error  al mover archivo ';
                    }
                } elseif(count($data_post) > 0) {
                    $file_name = 'alert.png';
                    $query = 'INSERT INTO lib_tipo_material (name, descripcion, icono, date_create, date_modify) '
                            . ' values("' . $data_post['InputNameTipoMaterial'] . '", "' . $data_post['InputDescripcion'] . '",'
                            . '"' . $file_name . '", "' . date('Y-m-d H:i:s') . '", "' . date('Y-m-d H:i:s') . '")';
                    $exec = mysql_query($query, $this->Conexion());
                    if ($exec) {
                        $ope = $this->GetTipoMaterial();
                    } else {
                        $ope = '<h4>Error en la insercion del registro</h4>';
                    }
                } else {
                    $ope = 'Error en el envio la recepción de archivo --> ' . $value['error'];
                }
            }
        }
        return $ope;
    }

    //Actualiza registro
    public function UpdateRegistro($data_post = NULL, $data_file = NULL) {
        if (count($data_file) > 0 && count($data_post) > 0) {
            $ruta_img = '../img/';
            foreach ($data_file as $value) {
                //Verificando que no existan errores en el envio del archivo
                if ($value['error'] == UPLOAD_ERR_OK) {
                    $file_name = $value['name'];
                    $file_tmp_name = $value['tmp_name'];
                    $ruta_final = $ruta_img . $file_name;
                    $result = move_uploaded_file($file_tmp_name, $ruta_final);
                    if ($result) {
                        $query = 'UPDATE lib_tipo_material SET name = "' . $data_post['InputNameTipoMaterial'] . '", '
                                . 'descripcion = "' . $data_post['InputDescripcion'] . '", '
                                . 'icono = "' . $file_name . '", date_modify = "' . date('Y-m-d H:i:s') . '"'
                                . ' WHERE id = ' . $data_post['id'];
                        $exec = mysql_query($query, $this->Conexion());
                        if ($exec) {
                            $ope = $this->GetTipoMaterial();
                        } else {
                            $ope = '<h4>Error en la insercion del registro</h4>';
                        }
                    } else {
                        $ope = 'Operación de subir archivo con error  al mover archivo ';
                    }
                }
                //Si no actualiza la imagen pero si los textos
                elseif (count($data_post) > 0) {
                    $query = 'UPDATE lib_tipo_material SET name = "' . $data_post['InputNameTipoMaterial'] . '", '
                            . 'descripcion = "' . $data_post['InputDescripcion'] . '", '
                            . 'date_modify = "' . date('Y-m-d H:i:s') . '"'
                            . ' WHERE id = ' . $data_post['id'];
                    $exec = mysql_query($query, $this->Conexion());
                    if ($exec) {
                        $ope = $this->GetTipoMaterial();
                    } else {
                        $ope = '<h4>Error en la insercion del registro</h4>';
                    }
                } else {
                    $ope = 'Error en el envio la recepción de archivo --> ' . $value['error'];
                }
            }
        }
        return $ope;
    }

}
