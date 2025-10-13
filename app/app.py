# app.py
from typing import Optional, List
from fastapi import FastAPI, HTTPException, status, Depends
from pydantic import BaseModel, EmailStr, Field
import psycopg
import bcrypt
import os
from datetime import datetime



# --- Config conexión (puedes también usar variables de entorno) ---
DB_CONN = os.getenv("DB_CONN", "dbname=sisvisitas user=admininfotec password=InfotecAdmi1. host=localhost")

app = FastAPI(title="Simulación SISVISITAS API")

from fastapi.middleware.cors import CORSMiddleware

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],  # en pruebas se deja "*", luego puedes restringirlo
    allow_credentials=True,
    allow_methods=["*"],  # GET, POST, PUT, DELETE
    allow_headers=["*"],  # autorizaciones y content-type
)
# ----------------------------
# Pydantic models (request/response)
# ----------------------------
class UserCreate(BaseModel):
    nombre: str = Field(..., example="Juan Perez")
    correo: EmailStr = Field(..., example="juan@example.com")
    contrasena: str = Field(..., example="MiPass123!")
    rol: str = Field(..., example="solicitante")  # 'administrador'|'administracion'|'solicitante'
    extension: Optional[str] = None

class UserOut(BaseModel):
    id_usuario: int
    nombre: str
    correo: EmailStr
    rol: str
    extension: Optional[str]
    activo: bool
    fecha_creacion: datetime

class LoginRequest(BaseModel):
    correo: EmailStr
    contrasena: str

class VisitCreate(BaseModel):
    id_solicitante: int
    id_delegado: Optional[int] = None
    fecha_hora: datetime
    motivo: str

class VisitOut(BaseModel):
    id_visita: int
    id_solicitante: int
    id_delegado: Optional[int]
    fecha_hora: datetime
    motivo: str
    estado: str
    comentario_admin: Optional[str]
    fecha_creacion: datetime
    fecha_modificacion: datetime

# ----------------------------
# Helpers
# ----------------------------
def get_conn():
    """Devuelve una nueva conexión; usar con context manager `with`."""
    return psycopg.connect(DB_CONN)

def hash_password(plain: str) -> str:
    h = bcrypt.hashpw(plain.encode("utf-8"), bcrypt.gensalt())
    return h.decode("utf-8")

def verify_password(plain: str, hashed: str) -> bool:
    return bcrypt.checkpw(plain.encode("utf-8"), hashed.encode("utf-8"))

# ----------------------------
# Endpoints usuarios
# ----------------------------
@app.post("/users", response_model=UserOut, status_code=status.HTTP_201_CREATED)
def create_user(payload: UserCreate):
    # validar rol simple
    if payload.rol not in ("administrador", "administracion", "solicitante"):
        raise HTTPException(status_code=400, detail="Rol inválido")

    hashed = hash_password(payload.contrasena)

    query = """
        INSERT INTO usuarios (nombre, correo, contrasena, rol, extension)
        VALUES (%s, %s, %s, %s, %s)
        RETURNING id_usuario, nombre, correo, rol, extension, activo, fecha_creacion;
    """
    try:
        with get_conn() as conn:
            with conn.cursor() as cur:
                cur.execute(query, (payload.nombre, payload.correo, hashed, payload.rol, payload.extension))
                row = cur.fetchone()
                if not row:
                    raise HTTPException(status_code=500, detail="No se pudo crear usuario")
                return {
                    "id_usuario": row[0],
                    "nombre": row[1],
                    "correo": row[2],
                    "rol": row[3],
                    "extension": row[4],
                    "activo": row[5],
                    "fecha_creacion": row[6],
                }
    except psycopg.errors.UniqueViolation:
        raise HTTPException(status_code=400, detail="Correo ya registrado")
    except Exception as e:
        raise HTTPException(status_code=500, detail=str(e))

@app.post("/auth/login")
def login(req: LoginRequest):
    q = "SELECT id_usuario, contrasena, nombre, rol FROM usuarios WHERE correo = %s AND activo = true"
    with get_conn() as conn:
        with conn.cursor() as cur:
            cur.execute(q, (req.correo,))
            r = cur.fetchone()
            if not r:
                raise HTTPException(status_code=401, detail="Usuario no encontrado o inactivo")
            id_user, hashed, nombre, rol = r
            if verify_password(req.contrasena, hashed):
                # En simulación no generamos token; devolvemos info mínima
                return {"id_usuario": id_user, "nombre": nombre, "rol": rol}
            else:
                raise HTTPException(status_code=401, detail="Credenciales incorrectas")

@app.get("/users", response_model=List[UserOut])
def list_users():
    q = "SELECT id_usuario, nombre, correo, rol, extension, activo, fecha_creacion FROM usuarios ORDER BY id_usuario;"
    with get_conn() as conn:
        with conn.cursor() as cur:
            cur.execute(q)
            rows = cur.fetchall()
            return [
                {
                    "id_usuario": r[0], "nombre": r[1], "correo": r[2],
                    "rol": r[3], "extension": r[4], "activo": r[5], "fecha_creacion": r[6]
                } for r in rows
            ]

@app.get("/users/{user_id}", response_model=UserOut)
def get_user(user_id: int):
    q = "SELECT id_usuario, nombre, correo, rol, extension, activo, fecha_creacion FROM usuarios WHERE id_usuario = %s;"
    with get_conn() as conn:
        with conn.cursor() as cur:
            cur.execute(q, (user_id,))
            r = cur.fetchone()
            if not r:
                raise HTTPException(status_code=404, detail="Usuario no encontrado")
            return {
                "id_usuario": r[0], "nombre": r[1], "correo": r[2],
                "rol": r[3], "extension": r[4], "activo": r[5], "fecha_creacion": r[6]
            }

@app.delete("/users/{user_id}", status_code=status.HTTP_204_NO_CONTENT)
def delete_user(user_id: int):
    q = "DELETE FROM usuarios WHERE id_usuario = %s RETURNING id_usuario;"
    with get_conn() as conn:
        with conn.cursor() as cur:
            cur.execute(q, (user_id,))
            r = cur.fetchone()
            if not r:
                raise HTTPException(status_code=404, detail="Usuario no encontrado")
            # commit ocurre al cerrar with conn
    return {"detail":"eliminado"}

# ----------------------------
# Endpoints visitas
# ----------------------------
@app.post("/visits", response_model=VisitOut, status_code=status.HTTP_201_CREATED)
def create_visit(payload: VisitCreate):
    q = """
    INSERT INTO visitas (id_solicitante, id_delegado, fecha_hora, motivo)
    VALUES (%s, %s, %s, %s)
    RETURNING id_visita, id_solicitante, id_delegado, fecha_hora, motivo, estado, comentario_admin, fecha_creacion, fecha_modificacion;
    """
    with get_conn() as conn:
        with conn.cursor() as cur:
            # validar que solicitante exista y esté activo
            cur.execute("SELECT id_usuario FROM usuarios WHERE id_usuario = %s AND activo = true", (payload.id_solicitante,))
            if not cur.fetchone():
                raise HTTPException(status_code=400, detail="Solicitante no válido o inactivo")
            # si delego fue provisto, verificar existe
            if payload.id_delegado:
                cur.execute("SELECT id_delegado FROM delegados WHERE id_delegado = %s", (payload.id_delegado,))
                if not cur.fetchone():
                    raise HTTPException(status_code=400, detail="Delegado no encontrado")

            cur.execute(q, (payload.id_solicitante, payload.id_delegado, payload.fecha_hora, payload.motivo))
            r = cur.fetchone()
            return {
                "id_visita": r[0], "id_solicitante": r[1], "id_delegado": r[2],
                "fecha_hora": r[3], "motivo": r[4], "estado": r[5],
                "comentario_admin": r[6], "fecha_creacion": r[7], "fecha_modificacion": r[8]
            }

@app.get("/visits", response_model=List[VisitOut])
def list_visits():
    q = """
    SELECT id_visita, id_solicitante, id_delegado, fecha_hora, motivo, estado, comentario_admin, fecha_creacion, fecha_modificacion
    FROM visitas ORDER BY fecha_hora DESC;
    """
    with get_conn() as conn:
        with conn.cursor() as cur:
            cur.execute(q)
            rows = cur.fetchall()
            return [
                {
                    "id_visita": r[0], "id_solicitante": r[1], "id_delegado": r[2],
                    "fecha_hora": r[3], "motivo": r[4], "estado": r[5],
                    "comentario_admin": r[6], "fecha_creacion": r[7], "fecha_modificacion": r[8]
                } for r in rows
            ]

@app.get("/visits/{visit_id}")
def get_visit(visit_id: int):
    """Devuelve visita y sus invitados y vehículos asociados"""
    visit_q = "SELECT id_visita, id_solicitante, id_delegado, fecha_hora, motivo, estado, comentario_admin, fecha_creacion, fecha_modificacion FROM visitas WHERE id_visita = %s;"
    guests_q = "SELECT id_invitado, nombre, fecha_creacion FROM invitados WHERE id_visita = %s;"
    vehicles_q = """
        SELECT ve.id_vehiculo, ve.id_invitado, ve.placas, ve.modelo, ve.color, ve.fecha_creacion
        FROM vehiculos ve
        JOIN invitados i ON ve.id_invitado = i.id_invitado
        WHERE i.id_visita = %s;
    """
    with get_conn() as conn:
        with conn.cursor() as cur:
            cur.execute(visit_q, (visit_id,))
            v = cur.fetchone()
            if not v:
                raise HTTPException(status_code=404, detail="Visita no encontrada")
            cur.execute(guests_q, (visit_id,))
            guests = cur.fetchall()
            cur.execute(vehicles_q, (visit_id,))
            vehicles = cur.fetchall()
            return {
                "visita": {
                    "id_visita": v[0], "id_solicitante": v[1], "id_delegado": v[2],
                    "fecha_hora": v[3], "motivo": v[4], "estado": v[5],
                    "comentario_admin": v[6], "fecha_creacion": v[7], "fecha_modificacion": v[8]
                },
                "invitados": [
                    {"id_invitado": g[0], "nombre": g[1], "fecha_creacion": g[2]} for g in guests
                ],
                "vehiculos": [
                    {"id_vehiculo": ve[0], "id_invitado": ve[1], "placas": ve[2], "modelo": ve[3], "color": ve[4], "fecha_creacion": ve[5]} for ve in vehicles
                ]
            }

@app.delete("/visits/{visit_id}", status_code=status.HTTP_204_NO_CONTENT)
def delete_visit(visit_id: int):
    q = "DELETE FROM visitas WHERE id_visita = %s RETURNING id_visita;"
    with get_conn() as conn:
        with conn.cursor() as cur:
            cur.execute(q, (visit_id,))
            r = cur.fetchone()
            if not r:
                raise HTTPException(status_code=404, detail="Visita no encontrada")
    return {"detail":"eliminado"}

# ----------------------------
# Run: uvicorn app:app --reload
# ----------------------------
