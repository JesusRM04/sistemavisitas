-- TABLA: roles
-- ================================================
CREATE TABLE roles (
    id_rol SERIAL PRIMARY KEY,
    nombre_rol VARCHAR(50) UNIQUE NOT NULL,
    descripcion TEXT
);
-- ================================================
-- TABLA: usuarios
-- ================================================
CREATE TABLE usuarios (
    id_usuario SERIAL PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    correo VARCHAR(255) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    id_rol INTEGER NOT NULL REFERENCES roles(id_rol) ON DELETE RESTRICT,
    extension VARCHAR(20),
    activo BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ================================================
-- TABLA: delegados
-- ================================================
CREATE TABLE delegados (
    id_delegado SERIAL PRIMARY KEY,
    id_solicitante INTEGER NOT NULL REFERENCES usuarios(id_usuario) ON DELETE CASCADE,
    id_usuario_delegado INTEGER NOT NULL REFERENCES usuarios(id_usuario) ON DELETE CASCADE,
    vigente BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT delegados_unique UNIQUE (id_solicitante, id_usuario_delegado)
);

-- ================================================
-- TABLA: visitas
-- ================================================
CREATE TABLE visitas (
    id_visita SERIAL PRIMARY KEY,
    id_solicitante INTEGER NOT NULL REFERENCES usuarios(id_usuario) ON DELETE RESTRICT,
    id_delegado INTEGER REFERENCES delegados(id_delegado) ON DELETE SET NULL,
    fecha_hora TIMESTAMP NOT NULL,
    motivo TEXT NOT NULL,
    estado VARCHAR(50) DEFAULT 'pendiente' CHECK (estado IN ('pendiente', 'autorizada', 'rechazada')),
    comentario_admin TEXT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ================================================
-- TABLA: invitados
-- ================================================
CREATE TABLE invitados (
    id_invitado SERIAL PRIMARY KEY,
    id_visita INTEGER NOT NULL REFERENCES visitas(id_visita) ON DELETE CASCADE,
    nombre VARCHAR(255) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ================================================
-- TABLA: vehiculos
-- ================================================
CREATE TABLE vehiculos (
    id_vehiculo SERIAL PRIMARY KEY,
    id_invitado INTEGER NOT NULL REFERENCES invitados(id_invitado) ON DELETE CASCADE,
    placas VARCHAR(20) NOT NULL,
    modelo VARCHAR(100),
    color VARCHAR(50),
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ================================================
-- TABLA: historial_visitas
-- ================================================
CREATE TABLE historial_visitas (
    id_historial SERIAL PRIMARY KEY,
    id_visita INTEGER NOT NULL REFERENCES visitas(id_visita) ON DELETE CASCADE,
    id_usuario INTEGER NOT NULL REFERENCES usuarios(id_usuario) ON DELETE RESTRICT,
    accion VARCHAR(50) NOT NULL CHECK (accion IN ('creación', 'modificación', 'autorización', 'rechazo')),
    fecha_accion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado_resultante VARCHAR(50)
);

-- ================================================
-- ÍNDICES
-- ================================================
CREATE INDEX idx_usuarios_correo ON usuarios(correo);
CREATE INDEX idx_usuarios_activo ON usuarios(activo);
CREATE INDEX idx_usuarios_rol ON usuarios(id_rol);
CREATE INDEX idx_roles_nombre ON roles(nombre_rol);
CREATE INDEX idx_delegados_solicitante ON delegados(id_solicitante);
CREATE INDEX idx_delegados_vigente ON delegados(vigente);
CREATE INDEX idx_visitas_solicitante ON visitas(id_solicitante);
CREATE INDEX idx_visitas_estado ON visitas(estado);
CREATE INDEX idx_visitas_fecha_hora ON visitas(fecha_hora);
CREATE INDEX idx_invitados_visita ON invitados(id_visita);
CREATE INDEX idx_vehiculos_invitado ON vehiculos(id_invitado);
CREATE INDEX idx_historial_visita ON historial_visitas(id_visita);

-- ================================================
-- TRIGGER: actualizar fecha_modificacion en visitas
-- ================================================
CREATE OR REPLACE FUNCTION actualizar_fecha_modificacion()
RETURNS TRIGGER AS $$
BEGIN
    NEW.fecha_modificacion = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_actualizar_fecha_modificacion
BEFORE UPDATE ON visitas
FOR EACH ROW
EXECUTE FUNCTION actualizar_fecha_modificacion();

-- ================================================
-- COMENTARIOS
-- ================================================
COMMENT ON TABLE roles IS 'Roles disponibles para los usuarios del sistema';
COMMENT ON TABLE usuarios IS 'Usuarios del sistema con diferentes roles';
COMMENT ON TABLE delegados IS 'Delegación de permisos entre usuarios';
COMMENT ON TABLE visitas IS 'Registro de visitas solicitadas';
COMMENT ON TABLE invitados IS 'Personas invitadas en cada visita';
COMMENT ON TABLE vehiculos IS 'Vehículos asociados a invitados';
COMMENT ON TABLE historial_visitas IS 'Historial de cambios en las visitas';