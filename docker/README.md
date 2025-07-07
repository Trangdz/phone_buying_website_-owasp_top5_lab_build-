# Thư mục docker/

Thư mục này dùng để quản lý các file cấu hình môi trường cho dự án Laravel khi chạy bằng Docker.

## Cấu trúc

- `mysql/conf.d/my.cnf`: Cấu hình MySQL (charset, collation, ...)
- `nginx/conf.d/default.conf`: Cấu hình Nginx cho ứng dụng Laravel
- `php/php.ini`: Cấu hình PHP (memory_limit, upload_max_filesize, ...)

## Cách sử dụng

- Khi cần thay đổi cấu hình môi trường (MySQL, Nginx, PHP), chỉ cần sửa các file trong thư mục này.
- Sau khi sửa, khởi động lại container tương ứng để áp dụng thay đổi:
  - MySQL: `docker-compose restart mysql`
  - Nginx: `docker-compose restart nginx`
  - PHP: `docker-compose restart php`

## Lợi ích
- Dễ bảo trì, backup, chia sẻ cấu hình môi trường.
- Đảm bảo môi trường dev/prod đồng nhất.
- Tách biệt code và cấu hình môi trường. 