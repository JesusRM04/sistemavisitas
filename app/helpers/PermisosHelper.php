<?php
/**
 * Helper para gestión de permisos
 * Centraliza todas las validaciones de acceso
 */

class PermisosHelper {
    
    private $pdo;
    private $id_rol;
    private $id_usuario;
    private $permisos_cache = [];
    
    public function __construct($pdo, $id_rol, $id_usuario = null) {
        $this->pdo = $pdo;
        $this->id_rol = $id_rol;
        $this->id_usuario = $id_usuario;
        $this->cargarPermisos();
    }
    
    /**
     * Cargar todos los permisos del rol en memoria
     */
    private function cargarPermisos() {
        $sql = "SELECT 
            m.nombre_modulo,
            p.puede_ver,
            p.puede_crear,
            p.puede_editar,
            p.puede_eliminar,
            p.alcance
        FROM permisos p
        JOIN modulos m ON p.id_modulo = m.id_modulo
        WHERE p.id_rol = :id_rol AND m.activo = TRUE";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_rol' => $this->id_rol]);
        $permisos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($permisos as $permiso) {
            $this->permisos_cache[$permiso['nombre_modulo']] = [
                'ver' => (bool)$permiso['puede_ver'],
                'crear' => (bool)$permiso['puede_crear'],
                'editar' => (bool)$permiso['puede_editar'],
                'eliminar' => (bool)$permiso['puede_eliminar'],
                'alcance' => $permiso['alcance'] // 'propios' o 'todos'
            ];
        }
    }
    
    /**
     * Verificar si tiene permiso para VER un módulo
     */
    public function puedeVer($modulo) {
        return isset($this->permisos_cache[$modulo]) && $this->permisos_cache[$modulo]['ver'];
    }
    
    /**
     * Verificar si tiene permiso para CREAR en un módulo
     */
    public function puedeCrear($modulo) {
        return isset($this->permisos_cache[$modulo]) && $this->permisos_cache[$modulo]['crear'];
    }
    
    /**
     * Verificar si tiene permiso para EDITAR en un módulo
     */
    public function puedeEditar($modulo) {
        return isset($this->permisos_cache[$modulo]) && $this->permisos_cache[$modulo]['editar'];
    }
    
    /**
     * Verificar si tiene permiso para ELIMINAR en un módulo
     */
    public function puedeEliminar($modulo) {
        return isset($this->permisos_cache[$modulo]) && $this->permisos_cache[$modulo]['eliminar'];
    }
    
    /**
     * NUEVO: Obtener el alcance de los permisos
     * Retorna 'propios' o 'todos'
     */
    public function getAlcance($modulo) {
        return isset($this->permisos_cache[$modulo]) ? $this->permisos_cache[$modulo]['alcance'] : 'propios';
    }
    
    /**
     * NUEVO: Verificar si puede ver todos los registros o solo los propios
     */
    public function puedoVerTodos($modulo) {
        return $this->getAlcance($modulo) === 'todos';
    }
    
    /**
     * NUEVO: Verificar si solo puede ver sus propios registros
     */
    public function soloMisPropios($modulo) {
        return $this->getAlcance($modulo) === 'propios';
    }
    
    /**
     * NUEVO: Aplicar filtro de alcance a una consulta SQL
     * Retorna condición WHERE para agregar a la consulta
     */
    public function aplicarFiltroAlcance($modulo, $campo_usuario = 'id_usuario', $tabla_alias = 'v') {
        if ($this->soloMisPropios($modulo) && $this->id_usuario) {
            return " AND {$tabla_alias}.{$campo_usuario} = {$this->id_usuario} ";
        }
        return "";
    }
    
    /**
     * NUEVO: Verificar si puede modificar un registro específico
     * Usado para editar/eliminar - debe ser propietario si alcance es 'propios'
     */
    public function puedeModificarRegistro($modulo, $id_usuario_registro) {
        if ($this->soloMisPropios($modulo)) {
            return $this->id_usuario == $id_usuario_registro;
        }
        return true; // Si puede ver todos, puede modificar todos
    }
    
    /**
     * Obtener todos los módulos con acceso
     */
    public function getModulosConAcceso() {
        $modulos = [];
        foreach ($this->permisos_cache as $nombre_modulo => $permisos) {
            if ($permisos['ver']) {
                $modulos[] = $nombre_modulo;
            }
        }
        return $modulos;
    }
    
    /**
     * Verificar permiso y redirigir si no tiene acceso
     */
    public function verificarPermiso($modulo, $accion = 'ver') {
        $tiene_permiso = false;
        
        switch ($accion) {
            case 'ver':
                $tiene_permiso = $this->puedeVer($modulo);
                break;
            case 'crear':
                $tiene_permiso = $this->puedeCrear($modulo);
                break;
            case 'editar':
                $tiene_permiso = $this->puedeEditar($modulo);
                break;
            case 'eliminar':
                $tiene_permiso = $this->puedeEliminar($modulo);
                break;
        }
        
        if (!$tiene_permiso) {
            session_start();
            $_SESSION['mensaje'] = "No tienes permisos para realizar esta acción";
            $_SESSION['icono'] = "error";
            
            global $URL;
            header('Location: ' . $URL);
            exit();
        }
        
        return true;
    }
    
    /**
     * Obtener menú dinámico según permisos
     */
    public function getMenuItems() {
        $sql = "SELECT 
            m.nombre_modulo,
            m.descripcion,
            m.icono,
            m.ruta,
            m.orden,
            p.puede_ver,
            p.puede_crear
        FROM modulos m
        LEFT JOIN permisos p ON m.id_modulo = p.id_modulo AND p.id_rol = :id_rol
        WHERE m.activo = TRUE AND p.puede_ver = TRUE
        ORDER BY m.orden ASC";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_rol' => $this->id_rol]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>