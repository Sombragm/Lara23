# Despliegue de Laravel en Railway

Este proyecto incluye los archivos base para desplegar en Railway:

- `railway.toml`
- `.env.dist` (solo para desarrollo local)

## 1) Crear el proyecto en Railway

1. Entra a Railway y crea un proyecto nuevo.
2. Elige `Deploy from GitHub Repo` y selecciona este repositorio.
3. Railway detectara `railway.toml` y aplicara el build/start automaticamente.

## 2) Variables de entorno

Configura en Railway (Environment Variables) como minimo:

Nota: no subas archivos `.env.example` al repo para evitar que Railway intente usarlos como base de variables.

- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_KEY` (generado con `php artisan key:generate --show`)
- `APP_URL=https://tu-app.up.railway.app`
- `DB_CONNECTION=mysql` (o `pgsql` si usas Postgres)
- `DB_URL` (connection string de la BD en Railway)

Recomendado para server stateless:

- `LOG_CHANNEL=stderr`
- `SESSION_DRIVER=cookie`
- `CACHE_STORE=array`
- `QUEUE_CONNECTION=sync`

## 3) Base de datos en Railway

1. Dentro del proyecto, agrega un servicio `MySQL` o `PostgreSQL`.
2. Copia la URL de conexion y pegala en `DB_URL` del servicio web.

## 4) Migraciones

Ejecuta migraciones en produccion con Railway CLI:

```bash
railway shell
php artisan migrate --force
```

## 5) Worker de colas (opcional)

Si tu app usara colas reales:

1. Crea un segundo servicio en Railway usando el mismo repositorio.
2. Usa este Start Command:

```bash
php artisan queue:work --tries=3 --timeout=90
```

## 6) Notas importantes

- Si guardas archivos subidos por usuarios, usa S3/Cloudinary u otro storage externo.
- Si necesitas tareas programadas (`schedule:run`), agregalas en un servicio aparte o cron externo.
