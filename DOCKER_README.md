# Docker Setup for Laravel Application

This Docker setup provides a complete environment for running the Laravel application with MySQL database and phpMyAdmin.

## Prerequisites

- Docker
- Docker Compose

## Quick Start

1. **Build and start the containers:**
   ```bash
   docker-compose up -d --build
   ```

2. **Run database migrations:**
   ```bash
   docker-compose exec app php artisan migrate
   ```

3. **Seed the database (optional):**
   ```bash
   docker-compose exec app php artisan db:seed
   ```

4. **Access the application:**
   - Laravel App: http://localhost:8080
   - phpMyAdmin: http://localhost:8081

## Services

- **App**: Laravel application running on Nginx + PHP-FPM (Port 8080)
- **MySQL**: Database server (Port 3306)
- **phpMyAdmin**: Database management interface (Port 8081)

## Environment Variables

The application uses the following environment variables (configured in docker-compose.yml):

- `DB_HOST=mysql`
- `DB_DATABASE=laravel`
- `DB_USERNAME=laravel`
- `DB_PASSWORD=secret`

## Useful Commands

### View logs
```bash
# All services
docker-compose logs

# Specific service
docker-compose logs app
docker-compose logs mysql
```

### Execute commands in container
```bash
# Run artisan commands
docker-compose exec app php artisan migrate
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear

# Access shell
docker-compose exec app sh
```

### Stop services
```bash
docker-compose down
```

### Stop and remove volumes (database data)
```bash
docker-compose down -v
```

## Development

For development, you can mount the source code as a volume by modifying the docker-compose.yml:

```yaml
volumes:
  - .:/var/www/html
  - ./storage:/var/www/html/storage
  - ./bootstrap/cache:/var/www/html/bootstrap/cache
```

## Troubleshooting

1. **Permission issues**: Make sure storage and bootstrap/cache directories are writable
2. **Database connection**: Wait for MySQL to fully start before running migrations
3. **Port conflicts**: Change ports in docker-compose.yml if 8080, 8081, or 3306 are already in use

## Production

For production deployment:

1. Update environment variables in docker-compose.yml
2. Set proper database credentials
3. Configure SSL certificates
4. Use production-optimized images
5. Set up proper backup strategies 