<?php
echo "🔍 DEBUG IMAGE PATHS\n\n";

// Test các đường dẫn image
$testPaths = [
    'products/CCmaMdqneFTtpOOp6vaSl5Z7gJdbQkcqXwV3H4L5.jpg',
    'telephones/wAwXrDL9DZaOAYX9ludJAQ3sqGnLkVnztqi5vDME.png',
    'products/WCMQZqfVAfCc4ZZwxta9S1pxhFmENvBsSlw78jgd.jpg',
    'products/CCNggggggA.png_1752175008.php'
];

foreach ($testPaths as $path) {
    echo "📁 Testing path: $path\n";
    
    // Kiểm tra file tồn tại trong storage
    $storagePath = "storage/app/public/" . $path;
    $exists = file_exists($storagePath);
    echo "   - Storage file exists: " . ($exists ? "✅ YES" : "❌ NO") . "\n";
    
    if ($exists) {
        echo "   - File size: " . filesize($storagePath) . " bytes\n";
        echo "   - File type: " . mime_content_type($storagePath) . "\n";
    }
    
    // Kiểm tra accessible via public/storage
    $publicPath = "public/storage/" . $path;
    $publicExists = file_exists($publicPath);
    echo "   - Public accessible: " . ($publicExists ? "✅ YES" : "❌ NO") . "\n";
    
    // Test URL path
    $url = "http://localhost/storage/" . $path;
    echo "   - Expected URL: $url\n";
    
    echo "\n";
}

// Test symlink
echo "🔗 SYMLINK TEST:\n";
$symlinkPath = "public/storage";
if (is_link($symlinkPath)) {
    echo "✅ Symlink exists\n";
    echo "   - Points to: " . readlink($symlinkPath) . "\n";
} else {
    echo "❌ Symlink does not exist\n";
}

// Test direct access
echo "\n🌐 DIRECT ACCESS TEST:\n";
echo "Try accessing these URLs in browser:\n";
foreach ($testPaths as $path) {
    if (file_exists("storage/app/public/" . $path)) {
        echo "✅ http://localhost/storage/$path\n";
    }
}
?> 