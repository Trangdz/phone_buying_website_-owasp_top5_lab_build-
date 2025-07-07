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
                sleep(5);
                // Kiểm tra extension (chỉ kiểm tra extension, không kiểm tra content)
                if ($this->checkFileType($extension)) {
                    // Xóa ảnh cũ nếu có
                    if ($telePhone->image && Storage::disk('public')->exists($telePhone->image)) {
                        Storage::disk('public')->delete($telePhone->image);
                    }
                    
                    // Lưu ảnh mới vào thư mục chính thức
                    $finalPath = $file->store('products', 'public');
                    $telePhone->image = $finalPath;
                    
                    session()->flash('success', 'Cập nhật thành công! File đã được xử lý an toàn.');
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
    
    
    public function delete($id){
        $telephone = Telephone::findOrFail($id);
        
        // Xóa ảnh liên quan
        if ($telephone->image && Storage::disk('public')->exists($telephone->image)) {
            Storage::disk('public')->delete($telephone->image);
        }

        $telephone->delete();

        return redirect()->back()->with('success', 'Telephone deleted successfully!');
    }
}
