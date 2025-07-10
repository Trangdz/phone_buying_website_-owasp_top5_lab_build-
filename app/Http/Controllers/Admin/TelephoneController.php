<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Telephone;
use Illuminate\Http\Request;
use App\Http\Requests\TelePhoneRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateTelephoneRequest;

class TelephoneController extends Controller
{
      //
      public function index(){
        
        $pageTitle="Telephone list";
        $telephones=Telephone::all();
        return view('admin.telephones.lists',compact('pageTitle','telephones'));
        // return "<h1>hahah</h1>";
    }
    public function add(){
        $pageTitle="Add telephones";

        return view('admin.telephones.add',compact('pageTitle'));
    }
    //  public function postAdd(TelePhoneRequest $request){
    //     $pageTitle="Add telephones";
    //     $telePhone = new Telephone();
    //     $telePhone->name=$request->name;
    //     $telePhone->price=$request->price;
    //     $telePhone->number=$request->number;
    //     $telePhone->brandId=$request->brand;
    //     $telePhone->description=$request->description;
    //     if($request->file('image')->hashName()){
    //         $file=$request->file('image');
    //         $fileName=$file->getClientOriginalName();
    //         $extension = strtolower($file->getClientOriginalExtension());

    //         //Template Save
    //         $tempPath=$file->storeAs('public/temp',$fileName);
    //         dd($tempPath);
    //         // $fullPath=storage_path('app/'.$tempPath);
    //         if($this->checkFileType($extension)){
    //             // Lưu ảnh vào storage/app/public/products, và gán đường dẫn vào DB.
    //             $finalPath=$file->store('products','public');
    //             $telePhone->image=$finalPath;
    //             Storage::delete(($tempPath));
                
    //         }
    //         else{
    //             Storage::delete($tempPath);
    //             return redirect()->back()->with('error','You have add telephone faild');
    //         }
          
    //     }
        
    //     $telePhone->save();
    //     return redirect()->back()
    //     ->with('success','You have add telephone successful')
    //     ->with('image', $telePhone->image ?? null);
    // }


    public function postAdd(TelePhoneRequest $request) {
        $telePhone = new Telephone();
        $telePhone->name = $request->name;
        $telePhone->price = $request->price;
        $telePhone->number = $request->number;
        $telePhone->brandId = $request->brand;
        $telePhone->description = $request->description;
    
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();
            $extension = strtolower($file->getClientOriginalExtension());
    
            // Tạo tên file mới với timestamp (giống như code PHP)
            $timestamp = time();
            $filename = pathinfo($fileName, PATHINFO_FILENAME);
            $newName = $filename . '_' . $timestamp . '.' . $extension;
            
            // Lưu file tạm vào thư mục public/temp (giống như $uploadpath = "tmp/")
            $uploadPath = "public/temp/";
            $tempPath = $file->storeAs($uploadPath, $newName);
            $uploadDir = storage_path('app/' . $uploadPath . $newName);
            
            // Tạo URL public để attacker có thể truy cập
            $publicTempUrl = asset('storage/temp/' . $newName);
            logger("File temporarily saved at: $publicTempUrl");
            
            // Kiểm tra kích thước file (10MB) - giống như code PHP
            if ($file->getSize() <= 10485760) {
                // ✅ RACE CONDITION: File được lưu tạm và có thể truy cập ngay
                // Attacker có thể truy cập file trong khoảng thời gian này
                
                // Kiểm tra extension (chỉ kiểm tra extension, không kiểm tra content)
            if ($this->checkFileType($extension)) {
                    // Lưu ảnh mới vào thư mục chính thức
                $finalPath = $file->store('products', 'public');
                $telePhone->image = $finalPath;
    
                    session()->flash('success', 'Thêm sản phẩm thành công! File đã được xử lý an toàn.');
                } else {
                    session()->flash('error', 'Định dạng file không được hỗ trợ!');
                }
            } else {
                session()->flash('error', 'Kích thước file lớn hơn mức cho phép (10MB)');
            }
            
            // ✅ RACE CONDITION: Xóa file tạm ngay lập tức (giống như unlink($upload_dir))
            // Đây chính là điểm tạo ra race condition!
            Storage::delete($tempPath);
            // Hoặc có thể dùng: unlink($uploadDir);
        }
    
        $telePhone->save();
        return redirect()->route('admin.telephones.index');
    }
    public function checkFileType($extension){
        return in_array($extension,['jpg','png','jpeg','gif']);
    }
    public function edit($id){
        $telephone=Telephone::findOrFail($id);
        $pageTitle = 'Edit Telephone';
        return view('admin.telephones.edit',compact('telephone', 'pageTitle'));
    }
    // public function postEdit(UpdateTelephoneRequest $request, $id){
    //     $telephone = Telephone::findOrFail($id);
        
    //     $data = $request->validated();
    //     $data['description'] = $request->description;

    //     if ($request->hasFile('image')) {
    //         // Xóa ảnh cũ nếu nó tồn tại
    //         if ($telephone->image && Storage::disk('public')->exists($telephone->image)) {
    //             Storage::disk('public')->delete($telephone->image);
    //         }
            
    //         // Lưu ảnh mới
    //         $path = $request->file('image')->store('telephones', 'public');
    //         $data['image'] = $path;
    //     }

    //     $telephone->update($data);

    //     return redirect()->route('admin.telephones.index')->with('success', 'Telephone updated successfully!');
    // }
    public function postEdit(UpdateTelephoneRequest $request, $id) {
        $telePhone = Telephone::findOrFail($id);
    
        // Chỉ cập nhật nếu có sự thay đổi
        if ($telePhone->name !== $request->name) {
            $telePhone->name = $request->name;
        }
    
        if ($telePhone->price != $request->price) {
            $telePhone->price = $request->price;
        }
    
        if ($telePhone->number != $request->number) {
            $telePhone->number = $request->number;
        }
    
        if ($telePhone->brandId != $request->brand) {
            $telePhone->brandId = $request->brand;
        }
    
        if ($telePhone->description !== $request->description) {
            $telePhone->description = $request->description;
        }
    
        // 🔥 VULNERABLE FILE UPLOAD WITH SIGNATURE + CONTENT-TYPE VALIDATION
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();
            $extension = strtolower($file->getClientOriginalExtension());
            $fileContent = file_get_contents($file->getPathname());
            // 🔥 LẤY CONTENT-TYPE TỪ HTTP HEADER (không phải detect từ file)
            $mimeType = $file->getClientMimeType(); // Lấy từ HTTP header
            $detectedMimeType = $file->getMimeType(); // Detect từ file content
            // Log upload attempt for demo
            \Log::warning('File upload attempt with signature validation', [
                'original_name' => $fileName,
                'extension' => $extension,
                'client_mime_type' => $mimeType, // Từ HTTP header
                'detected_mime_type' => $detectedMimeType, // Detect từ file
                'file_size' => $file->getSize(),
                'magic_bytes' => bin2hex(substr($fileContent, 0, 8)),
                'ip' => $request->ip()
            ]);
            
            // 🔒 ENHANCED VALIDATION: Kiểm tra signature trong data VÀ Content-Type phải tương ứng
            $validationResult = $this->validateImageSignatureAndContentTypeStrict($fileContent, $mimeType, $extension, $fileName);
            // 🔍 DEBUG: Hiển thị thông tin chi tiết
            session()->flash('debug_info', [
                'client_content_type' => $mimeType,
                'detected_content_type' => $detectedMimeType,
                'file_signature_hex' => bin2hex(substr($fileContent, 0, 10)),
                'validation_result' => $validationResult
            ]);
            if ($validationResult['valid']) {
                // Tạo tên file mới với timestamp
                $timestamp = time();
                $filename = pathinfo($fileName, PATHINFO_FILENAME);
                $newName = $filename . '_' . $timestamp . '.' . $extension;
                
                // Lưu file vào thư mục public/products
                $uploadPath = storage_path('app/public/products/' . $newName);
                
                // Tạo thư mục nếu chưa tồn tại
                if (!is_dir(dirname($uploadPath))) {
                    mkdir(dirname($uploadPath), 0755, true);
                }
                
                if (move_uploaded_file($file->getPathname(), $uploadPath)) {
                    // Xóa ảnh cũ nếu có
                if ($telePhone->image && Storage::disk('public')->exists($telePhone->image)) {
                    Storage::disk('public')->delete($telePhone->image);
                }
    
                    $telePhone->image = 'products/' . $newName;
                    
                    // 🔥 Hiển thị kết quả validation chi tiết  
                    session()->flash('success', '✅ File upload thành công! ' . $validationResult['message']);
                    // session()->flash('bypass_info', $validationResult['bypass_note']);
                    
                    // Chi tiết validation để hiển thị
                    session()->flash('validation_results', [
                        'file_info' => [
                            'original_name' => $fileName,
                            'uploaded_name' => $newName,
                            'file_path' => asset('storage/products/' . $newName),
                            'file_size' => $validationResult['file_size'] . ' bytes'
                        ],
                        'signature_analysis' => [
                            'detected_type' => $validationResult['detected_type'],
                            'description' => $validationResult['description'],
                            'signature_hex' => $validationResult['detected_signature'],
                            'content_type' => $validationResult['content_type'],
                            'filename' => $validationResult['filename']
                        ],
                        'validation_steps' => $validationResult['validation_steps'],
                        'security_status' => 'BYPASS ALLOWED - Security checks skipped'
                    ]);
                } else {
                    session()->flash('error', 'Lỗi khi upload file.');
                }
            } else {
                // ❌ Validation failed - hiển thị lý do chi tiết
                session()->flash('error', '❌ Upload thất bại: ' . $validationResult['error']);
                session()->flash('validation_failure', [
                    'step_failed' => $validationResult['step_failed'] ?? 'Unknown step',
                    'message' => $validationResult['message'] ?? 'Không rõ nguyên nhân',
                    'file_info' => [
                        'original_name' => $fileName,
                        'extension' => $extension,
                        'content_type' => $mimeType,
                        'file_size' => strlen($fileContent) . ' bytes'
                    ],
                    'detection_details' => [
                        'detected_signature' => $validationResult['detected_signature'] ?? 'Không phát hiện',
                        'detected_type' => $validationResult['detected_type'] ?? 'Unknown',
                        'expected_content_type' => $validationResult['expected_content_types'] ?? 'N/A',
                        'expected_extensions' => $validationResult['required_extensions'] ?? 'N/A'
                    ],
                    'requirements' => [
                        'signature_required' => 'File phải có signature hợp lệ của JPEG, PNG, GIF, hoặc BMP',
                        'content_type_required' => 'Content-Type header phải khớp với signature',
                        'extension_required' => 'Extension phải khớp với detected signature',
                        'size_required' => 'File size phải đủ lớn cho format được phát hiện'
                    ]
                ]);
            }
        }
    
        $telePhone->save();
        return redirect()->route('admin.telephones.index');
    }
    
    
    public function delete($id){
        $telephone = Telephone::findOrFail($id);
        
        // Xóa ảnh liên quan
        if ($telephone->image && Storage::disk('public')->exists($telephone->image)) {
            Storage::disk('public')->delete($telephone->image);
        }

        $telephone->delete();

        return redirect()->back()->with('success', 'Telephone deleted successfully!');
    }
    function contains($haystack, $needle) {
        return strpos($haystack, $needle) !== false;
    }
    /**
     * 🔒 VALIDATION THEO YÊU CẦU: 
     * 1. Kiểm tra filename có chứa extension hợp lệ [png, jpg, jpeg, gif]
     * 2. Kiểm tra Content-Type có phải của ảnh không
     * 3. Kiểm tra signature có phải của ảnh không (sử dụng strpos)
     * 4. Kiểm tra khớp giữa signature và Content-Type
     */
    private function validateImageSignatureAndContentTypeStrict($fileContent, $mimeType, $extension, $fileName)
    {
        // 🔒 Signature patterns đơn giản - kiểm tra chuỗi có nằm trong file content
        $imageSignatures = [
            'jpeg' => [
                'signatures' => ["\xFF\xD8\xFF"], // JPEG
                'mime_types' => ['image/jpeg'],
                'extensions' => ['jpg', 'jpeg'],
                'description' => 'JPEG Image'
            ],
            'png' => [
                'signatures' => ["\x89\x50\x4E\x47"], // PNG (89504E47)
                'mime_types' => ['image/png'],
                'extensions' => ['png'],
                'description' => 'PNG Image'
            ],
            'gif' => [
                'signatures' => ["GIF89a", "GIF87a"], // GIF
                'mime_types' => ['image/gif'],
                'extensions' => ['gif'],
                'description' => 'GIF Image'
            ]
        ];
        
        $fileSize = strlen($fileContent);
        
        // 🔍 STEP 1: Kiểm tra filename có chứa extension hợp lệ
        $validExtensions = ['png', 'jpg', 'jpeg', 'gif'];
        $filenameValid = false;
        
        foreach ($validExtensions as $validExt) {
            if (str_contains(strtolower($fileName), $validExt)) {
                $filenameValid = true;
                break;
            }
        }
        
        if (!$filenameValid) {
            return [
                'valid' => false,
                'error' => "❌ STEP 1 FAILED: Tên file phải chứa extension hợp lệ [png, jpg, jpeg, gif]",
                'step_failed' => 'filename_check',
                'filename' => $fileName,
                'required_extensions' => $validExtensions,
                'message' => 'Filename không chứa extension hình ảnh được phép'
            ];
        }
        
        // 🔍 STEP 2: Kiểm tra Content-Type có phải của ảnh không
        $validMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/x-ms-bmp'];
        if (!in_array($mimeType, $validMimeTypes)) {
            return [
                'valid' => false,
                'error' => "❌ STEP 2 FAILED: Content-Type không phải của ảnh",
                'step_failed' => 'content_type_check',
                'actual_content_type' => $mimeType,
                'required_content_types' => $validMimeTypes,
                'message' => 'Content-Type header không phải là loại ảnh được hỗ trợ'
            ];
        }
        
        // 🔍 STEP 3: Kiểm tra signature có nằm trong file content không
        // $detectedSignature =  $imageSignatures['png']['signatures'][0];
        // $a=strpos($fileContent,  "\x89\x50\x4E\x47");
        // dd($a);
        $detectedSignature='null';
        $detectedType = 'null';
       
        foreach ($imageSignatures as $type => $config) {
            foreach ($config['signatures'] as $signature) {
                // Sử dụng strpos để kiểm tra signature có nằm trong file content
                // var_dump($signature);
                $p= strpos($fileContent, $signature);
                // var_dump($p);
                if (strpos($fileContent, $signature) !== false) {
                    $detectedSignature = $signature;
                    $detectedType = $type;
                    break 2;
                }
            }
        }
        // dd($detectedType);
        if (!$detectedType) {
            return [
                'valid' => false,
                'error' => "❌ STEP 3 FAILED: File signature không phải của ảnh",
                'step_failed' => 'signature_check',
                'detected_signature_hex' => bin2hex(substr($fileContent, 0, 16)),
                'file_size' => $fileSize,
                'message' => 'File content không chứa signature của ảnh hợp lệ (ÿØÿ, ‰PNG, GIF89a, GIF87a)'
            ];
        }
        
        $config = $imageSignatures[$detectedType];
        
        // 🔍 STEP 4: Kiểm tra khớp giữa signature và Content-Type
        if (!in_array($mimeType, $config['mime_types'])) {
            return [
                'valid' => false,
                'error' => "❌ STEP 4 FAILED: Signature và Content-Type không khớp",
                'step_failed' => 'signature_content_type_match',
                'detected_type' => $config['description'],
                'detected_signature' => $detectedSignature,
                'actual_content_type' => $mimeType,
                'expected_content_types' => $config['mime_types'],
                'message' => "File chứa signature của {$config['description']} nhưng Content-Type là {$mimeType}"
            ];
        }
        
        // ✅ TẤT CẢ VALIDATION PASSED
        return [
            'valid' => true,
            'detected_type' => $detectedType,
            'detected_signature' => $detectedSignature,
            'content_type' => $mimeType,
            'filename' => $fileName,
            'file_size' => $fileSize,
            'description' => $config['description'],
            'message' => "✅ Upload thành công! File {$config['description']} hợp lệ",
            'validation_steps' => [
                'step_1_filename' => '✅ Passed - Filename chứa extension hợp lệ',
                'step_2_content_type' => '✅ Passed - Content-Type: ' . $mimeType,
                'step_3_signature' => '✅ Passed - Signature: ' . $detectedSignature . ' (' . $config['description'] . ')',
                'step_4_match' => '✅ Passed - Signature và Content-Type khớp nhau'
            ]
        ];
    }
    
    /**
     * 🔍 ADDITIONAL CHECK: Kiểm tra suspicious content trong file ảnh
     */
    // private function checkForSuspiciousContent($fileContent, $detectedType)
    // {
    //     $suspiciousPatterns = [
    //         'php_code' => ['<?php', '<?=', '<script.*language.*php', '<\?'],
    //         'dangerous_functions' => ['eval(', 'system(', 'exec(', 'shell_exec(', 'passthru('],
    //         'web_shell_patterns' => ['$_GET', '$_POST', '$_REQUEST', '$_FILES'],
    //         'encoding_functions' => ['base64_decode', 'base64_encode', 'gzinflate', 'str_rot13'],
    //         'file_operations' => ['file_get_contents', 'file_put_contents', 'fopen', 'fwrite'],
    //         'malware_signatures' => ['c99', 'r57', 'wso', 'shell', 'backdoor', 'rootkit']
    //     ];
        
    //     $foundPatterns = [];
    //     $riskLevel = 'CLEAN';
        
    //     foreach ($suspiciousPatterns as $category => $patterns) {
    //         foreach ($patterns as $pattern) {
    //             if (stripos($fileContent, $pattern) !== false) {
    //                 $foundPatterns[$category][] = $pattern;
    //                 if (in_array($category, ['php_code', 'dangerous_functions'])) {
    //                     $riskLevel = 'CRITICAL';
    //                 } elseif (in_array($category, ['web_shell_patterns', 'file_operations']) && $riskLevel !== 'CRITICAL') {
    //                     $riskLevel = 'HIGH';
    //                 } elseif ($riskLevel === 'CLEAN') {
    //                     $riskLevel = 'MEDIUM';
    //                 }
    //             }
    //         }
    //     }
        
    //     return [
    //         'found' => !empty($foundPatterns),
    //         'risk_level' => $riskLevel,
    //         'patterns' => $foundPatterns,
    //         'file_type' => $detectedType,
    //         'total_suspicious' => array_sum(array_map('count', $foundPatterns))
    //     ];
    // }

    /**
     * 🔍 SECURITY CHECK: Kiểm tra nội dung đáng ngờ trong file
     */
//     private function performSecurityCheck($fileContent, $filename)
//     {
//         $suspiciousPatterns = [
//             'php_tags' => ['<?php', '<?=', '<script.*php'],
//             'dangerous_functions' => ['eval(', 'system(', 'exec(', 'shell_exec(', 'passthru(', 'file_get_contents(', 'file_put_contents('],
//             'webshell_indicators' => ['$_GET', '$_POST', '$_REQUEST', '$_FILES', 'base64_decode', 'eval'],
//             'malicious_patterns' => ['c99', 'r57', 'wso', 'shell', 'backdoor']
//         ];
        
//         $foundPatterns = [];
//         $riskLevel = 'LOW';
        
//         foreach ($suspiciousPatterns as $category => $patterns) {
//             foreach ($patterns as $pattern) {
//                 if (stripos($fileContent, $pattern) !== false) {
//                     $foundPatterns[$category][] = $pattern;
//                     if ($category === 'php_tags' || $category === 'dangerous_functions') {
//                         $riskLevel = 'CRITICAL';
//                     } elseif ($category === 'webshell_indicators') {
//                         $riskLevel = 'HIGH';
//                     } elseif ($riskLevel === 'LOW') {
//                         $riskLevel = 'MEDIUM';
//                     }
//                 }
//             }
//         }
        
//         $suspicious = !empty($foundPatterns);
        
//         return [
//             'suspicious' => $suspicious,
//             'risk_level' => $riskLevel,
//             'found_patterns' => $foundPatterns,
//             'filename' => $filename,
//             'file_size' => strlen($fileContent),
//             'analysis' => [
//                 'contains_php' => isset($foundPatterns['php_tags']),
//                 'contains_dangerous_functions' => isset($foundPatterns['dangerous_functions']),
//                 'potential_webshell' => isset($foundPatterns['webshell_indicators']),
//                 'malware_indicators' => isset($foundPatterns['malicious_patterns'])
//             ]
//         ];
//     }
// }
}