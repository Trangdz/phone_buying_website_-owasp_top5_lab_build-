# -------------------------
# Stage 1: Build frontend assets with Node.js
# -------------------------
    FROM node:18-alpine AS node-builder

    WORKDIR /app
    
    # Cài Node module
    COPY package*.json ./
    RUN npm install
    
    # Copy toàn bộ mã nguồn
    COPY . .
    
    # Không build vì sẽ chạy dev
    # RUN npm run build
    
    
    # -------------------------
    # Stage 2: Laravel App chạy với PHP built-in + Vite Dev
    # -------------------------
    FROM php:8.1-cli-alpine
    
    # Cài các dependency cần thiết
    RUN apk add --no-cache \
        git \
        curl \
        mysql-client \
        bash \
        oniguruma-dev \
        libzip-dev \
        zip \
        unzip \
        nodejs \
        npm \
        shadow
    
    # Cài các PHP extension
    RUN docker-php-ext-install \
        pdo_mysql \
        mbstring \
        bcmath \
        zip \
        pcntl
    
    # Cài Composer
    COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
    
    # Set thư mục làm việc
    WORKDIR /app
    
    # Copy toàn bộ mã nguồn từ build node
    COPY --from=node-builder /app /app
    
    # Cài Laravel dependencies
    RUN composer install
    
    # Tạo .env nếu chưa có
    RUN cp .env.example .env || echo "APP_KEY=SomeDummyKey" > .env
    
    # Tạo app key
    RUN php artisan key:generate --force || echo "Laravel key skipped"
    
    # Cấp quyền thư mục
    RUN mkdir -p storage && chmod -R 775 storage bootstrap/cache
    
    # Mở cổng Laravel + Vite
    EXPOSE 8000 5173
    
    # Khởi động song song Laravel + Vite dev server
    CMD sh -c "npm install && npm run dev & php artisan serve --host=0.0.0.0 --port=8000"
    
    