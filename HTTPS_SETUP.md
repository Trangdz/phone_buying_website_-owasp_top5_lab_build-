# Hướng dẫn triển khai HTTPS cho dự án Laravel

## Tổng quan
Dự án đã được cấu hình để hỗ trợ HTTPS với SSL certificates tự ký (self-signed).

## Các file đã được cấu hình

### 1. Nginx Configuration
- File: `docker/nginx/conf.d/default.conf`
- Đã cấu hình:
  - Redirect HTTP (port 80) sang HTTPS (port 443)
  - SSL certificates và cấu hình bảo mật
  - HTTP/2 support
  - Security headers (HSTS, X-Frame-Options, etc.)

### 2. Docker Compose
- File: `docker-compose.yml`
- Đã thêm:
  - Port mapping 443:443 cho HTTPS
  - Volume mount cho SSL certificates

### 3. SSL Certificates
- Thư mục: `docker/nginx/ssl/`
- Các file cần thiết:
  - `server.crt` - Server certificate
  - `server.key` - Server private key
  - `rootCA.crt` - Root Certificate Authority
  - `rootCA.key` - Root CA private key

### 4. Laravel Middleware
- File: `app/Http/Middleware/ForceHttps.php`
- Đã đăng ký trong `app/Http/Kernel.php`
- Tự động redirect HTTP sang HTTPS trong production

## Cách chạy dự án với HTTPS

### 1. Khởi động containers
```bash
docker-compose up -d
```

### 2. Truy cập ứng dụng
- HTTP: `http://localhost:9001` (sẽ tự động redirect sang HTTPS)
- HTTPS: `https://localhost`

### 3. Cài đặt Root CA (để tránh cảnh báo trình duyệt)
1. Mở file `docker/nginx/ssl/rootCA.crt`
2. Cài đặt vào Trusted Root Certification Authorities
3. Trên Windows: Run as Administrator -> mmc -> Add/Remove Snap-in -> Certificates -> Computer Account -> Trusted Root Certification Authorities -> Certificates -> Import

## Lưu ý quan trọng

### Development vs Production
- Trong development: Sử dụng self-signed certificates
- Trong production: Nên sử dụng certificates từ CA uy tín (Let's Encrypt, etc.)

### Browser Warnings
- Trình duyệt sẽ hiển thị cảnh báo về self-signed certificate
- Cần cài đặt Root CA để tránh cảnh báo này

### Security Headers
- HSTS (HTTP Strict Transport Security) đã được bật
- Các security headers khác cũng đã được cấu hình

## Troubleshooting

### 1. Certificate không hoạt động
- Kiểm tra file certificates trong `docker/nginx/ssl/`
- Đảm bảo permissions đúng (600 cho private keys)

### 2. Port conflicts
- Đảm bảo port 443 không bị sử dụng bởi ứng dụng khác
- Kiểm tra firewall settings

### 3. Laravel không nhận HTTPS
- Kiểm tra middleware ForceHttps đã được đăng ký
- Đảm bảo TrustProxies middleware được cấu hình đúng

