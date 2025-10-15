# Create SSL certificates with SAN for localhost development
# This script creates self-signed certificates that work better with browsers

# Create ssl directory if it doesn't exist
if (!(Test-Path "docker\nginx\ssl")) {
    New-Item -ItemType Directory -Path "docker\nginx\ssl" -Force
}

# Create openssl config file with SAN
$opensslConfig = @"
[req]
default_bits = 2048
prompt = no
default_md = sha256
distinguished_name = dn
req_extensions = v3_req

[dn]
C=VN
ST=HCM
L=HCM
O=VNCS
OU=IT
CN=localhost

[v3_req]
basicConstraints = CA:FALSE
keyUsage = nonRepudiation, digitalSignature, keyEncipherment
subjectAltName = @alt_names

[alt_names]
DNS.1 = localhost
DNS.2 = *.localhost
IP.1 = 127.0.0.1
IP.2 = ::1
"@

$opensslConfig | Out-File -FilePath "docker\nginx\ssl\openssl.cnf" -Encoding ASCII

# Generate private key
docker run --rm -v "${PWD}/docker/nginx/ssl:/ssl" alpine/openssl genrsa -out /ssl/myapp.key 2048

# Generate certificate signing request with SAN
docker run --rm -v "${PWD}/docker/nginx/ssl:/ssl" alpine/openssl req -new -key /ssl/myapp.key -out /ssl/myapp.csr -config /ssl/openssl.cnf

# Generate self-signed certificate with SAN
docker run --rm -v "${PWD}/docker/nginx/ssl:/ssl" alpine/openssl x509 -req -days 365 -in /ssl/myapp.csr -signkey /ssl/myapp.key -out /ssl/myapp.crt -extensions v3_req -extfile /ssl/openssl.cnf

# Clean up
Remove-Item "docker\nginx\ssl\myapp.csr" -Force -ErrorAction SilentlyContinue
Remove-Item "docker\nginx\ssl\openssl.cnf" -Force -ErrorAction SilentlyContinue

Write-Host "SSL certificates with SAN created successfully!" -ForegroundColor Green
Write-Host "Files created:" -ForegroundColor Yellow
Write-Host "- docker\nginx\ssl\myapp.key (private key)" -ForegroundColor White
Write-Host "- docker\nginx\ssl\myapp.crt (certificate with SAN)" -ForegroundColor White
Write-Host ""
Write-Host "Certificate includes Subject Alternative Names for:" -ForegroundColor Cyan
Write-Host "- localhost" -ForegroundColor White
Write-Host "- *.localhost" -ForegroundColor White
Write-Host "- 127.0.0.1" -ForegroundColor White
Write-Host "- ::1" -ForegroundColor White
