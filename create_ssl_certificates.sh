#!/bin/bash

# Create SSL certificates for localhost development
# This script creates self-signed certificates for HTTPS

# Create ssl directory if it doesn't exist
mkdir -p docker/nginx/ssl

# Generate private key
openssl genrsa -out docker/nginx/ssl/myapp.key 2048

# Generate certificate signing request
openssl req -new -key docker/nginx/ssl/myapp.key -out docker/nginx/ssl/myapp.csr -subj "/C=VN/ST=HCM/L=HCM/O=VNCS/OU=IT/CN=localhost"

# Generate self-signed certificate
openssl x509 -req -days 365 -in docker/nginx/ssl/myapp.csr -signkey docker/nginx/ssl/myapp.key -out docker/nginx/ssl/myapp.crt

# Set proper permissions
chmod 600 docker/nginx/ssl/myapp.key
chmod 644 docker/nginx/ssl/myapp.crt

# Clean up CSR file
rm docker/nginx/ssl/myapp.csr

echo "SSL certificates created successfully!"
echo "Files created:"
echo "- docker/nginx/ssl/myapp.key (private key)"
echo "- docker/nginx/ssl/myapp.crt (certificate)"
echo ""
echo "Note: This is a self-signed certificate. Your browser will show a security warning."
echo "To bypass the warning:"
echo "1. Click 'Advanced' or 'Advanced settings'"
echo "2. Click 'Proceed to localhost (unsafe)' or similar option"
