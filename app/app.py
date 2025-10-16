from fastapi import FastAPI, HTTPException
import psycopg
import os

# Configuración de conexión PostgreSQL
DB_CONN = os.getenv(
    "DB_CONN",
    "dbname=sisvisitas user=admininfotec password=InfotecAdmi1. host=localhost port=5432"
)

app = FastAPI(title="Prueba de conexión - Sistema de Visitas")

# Función de conexión
def get_conn():
    """Crea y devuelve una nueva conexión a la base de datos."""
    try:
        conn = psycopg.connect(DB_CONN)
        return conn
    except Exception as e:
        raise HTTPException(status_code=500, detail=f"Error de conexión: {str(e)}")

# Endpoint de prueba
@app.get("/")
def probar_conexion():
    """Verifica si la conexión a la base de datos es exitosa."""
    try:
        with get_conn() as conn:
            with conn.cursor() as cur:
                cur.execute("SELECT version();")
                version = cur.fetchone()[0]
        return {
            "estado": "Conexión exitosa",
            "version_postgresql": version,
            "base_de_datos": "sisvisitas"
        }
    except Exception as e:
        raise HTTPException(status_code=500, detail=f"Error al conectar: {str(e)}")
    
# ----------------------------
# Run: uvicorn app:app --reload
# ----------------------------
