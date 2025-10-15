# Create proper SSL certificate chain with Root CA
# This script creates a Root CA and signs the server certificate with it

# Create ssl directory if it doesn't exist
if (!(Test-Path "docker\nginx\ssl")) {
    New-Item -ItemType Directory -Path "docker\nginx\ssl" -Force
}

# Create Root CA config
$rootCAConfig = @"
[req]
default_bits = 2048
prompt = no
default_md = sha256
distinguished_name = dn
x509_extensions = v3_ca

[dn]
C=VN
ST=HCM
L=HCM
O=VNCS Root CA
OU=IT
CN=VNCS Root CA

[v3_ca]
basicConstraints = critical,CA:TRUE
keyUsage = critical,keyCertSign,cRLSign
subjectKeyIdentifier = hash
"@

$rootCAConfig | Out-File -FilePath "docker\nginx\ssl\rootCA.cnf" -Encoding ASCII

# Create server certificate config with SAN
$serverConfig = @"
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

$serverConfig | Out-File -FilePath "docker\nginx\ssl\server.cnf" -Encoding ASCII

Write-Host "Creating Root CA..." -ForegroundColor Yellow

# Generate Root CA private key
docker run --rm -v "${PWD}/docker/nginx/ssl:/ssl" alpine/openssl genrsa -out /ssl/rootCA.key 2048

# Generate Root CA certificate
docker run --rm -v "${PWD}/docker/nginx/ssl:/ssl" alpine/openssl req -new -x509 -days 3650 -key /ssl/rootCA.key -out /ssl/rootCA.crt -config /ssl/rootCA.cnf

Write-Host "Creating server certificate..." -ForegroundColor Yellow

# Generate server private key
docker run --rm -v "${PWD}/docker/nginx/ssl:/ssl" alpine/openssl genrsa -out /ssl/myapp.key 2048

# Generate server certificate signing request
docker run --rm -v "${PWD}/docker/nginx/ssl:/ssl" alpine/openssl req -new -key /ssl/myapp.key -out /ssl/myapp.csr -config /ssl/server.cnf

# Sign server certificate with Root CA
docker run --rm -v "${PWD}/docker/nginx/ssl:/ssl" alpine/openssl x509 -req -in /ssl/myapp.csr -CA /ssl/rootCA.crt -CAkey /ssl/rootCA.key -CAcreateserial -out /ssl/myapp.crt -days 365 -extensions v3_req -extfile /ssl/server.cnf

# Clean up
Remove-Item "docker\nginx\ssl\myapp.csr" -Force -ErrorAction SilentlyContinue
Remove-Item "docker\nginx\ssl\rootCA.cnf" -Force -ErrorAction SilentlyContinue
Remove-Item "docker\nginx\ssl\server.cnf" -Force -ErrorAction SilentlyContinue

Write-Host "SSL certificate chain created successfully!" -ForegroundColor Green
Write-Host ""
Write-Host "Files created:" -ForegroundColor Yellow
Write-Host "- docker\nginx\ssl\rootCA.key (Root CA private key)" -ForegroundColor White
Write-Host "- docker\nginx\ssl\rootCA.crt (Root CA certificate)" -ForegroundColor White
Write-Host "- docker\nginx\ssl\myapp.key (Server private key)" -ForegroundColor White
Write-Host "- docker\nginx\ssl\myapp.crt (Server certificate signed by Root CA)" -ForegroundColor White
Write-Host ""
Write-Host "Now import docker\nginx\ssl\rootCA.crt into Firefox:" -ForegroundColor Cyan
Write-Host "1. Firefox → about:preferences#privacy" -ForegroundColor White
Write-Host "2. Certificates → View Certificates → Authorities" -ForegroundColor White
Write-Host "3. Import → Select rootCA.crt → Trust this CA to identify websites" -ForegroundColor White
