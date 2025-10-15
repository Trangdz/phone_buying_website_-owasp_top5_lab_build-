# Create SSL certificates for localhost development
# This script creates self-signed certificates for HTTPS

# Create ssl directory if it doesn't exist
if (!(Test-Path "docker\nginx\ssl")) {
    New-Item -ItemType Directory -Path "docker\nginx\ssl" -Force
}

# Generate private key
openssl genrsa -out docker\nginx\ssl\myapp.key 2048

# Generate certificate signing request
openssl req -new -key docker\nginx\ssl\myapp.key -out docker\nginx\ssl\myapp.csr -subj "/C=VN/ST=HCM/L=HCM/O=VNCS/OU=IT/CN=localhost"

# Generate self-signed certificate
openssl x509 -req -days 365 -in docker\nginx\ssl\myapp.csr -signkey docker\nginx\ssl\myapp.key -out docker\nginx\ssl\myapp.crt

# Set proper permissions
icacls docker\nginx\ssl\myapp.key /inheritance:r /grant:r "%USERNAME%:F"
icacls docker\nginx\ssl\myapp.crt /inheritance:r /grant:r "%USERNAME%:F"

# Clean up CSR file
Remove-Item docker\nginx\ssl\myapp.csr -Force

Write-Host "SSL certificates created successfully!" -ForegroundColor Green
Write-Host "Files created:" -ForegroundColor Yellow
Write-Host "- docker\nginx\ssl\myapp.key (private key)" -ForegroundColor White
Write-Host "- docker\nginx\ssl\myapp.crt (certificate)" -ForegroundColor White
Write-Host ""
Write-Host "Note: This is a self-signed certificate. Your browser will show a security warning." -ForegroundColor Red
Write-Host "To bypass the warning:" -ForegroundColor Yellow
Write-Host "1. Click 'Advanced' or 'Advanced settings'" -ForegroundColor White
Write-Host "2. Click 'Proceed to localhost (unsafe)' or similar option" -ForegroundColor White
