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
    
            // Lưu file tạm vào storage/app/public/temp
            $tempPath = $file->storeAs('public/temp', $fileName);
    
            // Lấy đường dẫn public để attacker có thể truy cập
            $publicTempUrl = asset('storage/temp/' . $fileName);
            logger("File temporarily saved at: $publicTempUrl");
            // dd($publicTempUrl);
 
            //  Giữ lại file 5 giây để attacker kịp truy cập trước khi xử lý
            // sleep(5);
    
            //  Kiểm tra extension
            if ($this->checkFileType($extension)) {
                // Di chuyển sang thư mục chính thức
                $finalPath = $file->store('products', 'public');
                $telePhone->image = $finalPath;
    
                // Xóa file tạm
                Storage::delete($tempPath);
            } else {
                Storage::delete($tempPath);
                return response("File bị từ chối. Nhưng có thể đã bị truy cập trước đó nếu bạn nhanh tay ;)", 400);
            }
        }
    
        $telePhone->save();
        return response("Upload thành công. Nếu bạn là attacker, thời điểm này đã quá muộn 😎");
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
    
            // ✅ 1. Lưu file vào thư mục tạm
            $tempPath = $file->storeAs('public/temp', $fileName);
    
            // ✅ 2. Cho attacker cơ hội khai thác
            $publicTempUrl = asset('storage/temp/' . $fileName);
            logger("Temporary image path: $publicTempUrl");
    
            sleep(5); // tạo khoảng thời gian race condition
    
            // ✅ 3. Kiểm tra định dạng hợp lệ
            if ($this->checkFileType($extension)) {
    
                // ✅ 4. Xóa ảnh cũ nếu có
                if ($telePhone->image && Storage::disk('public')->exists($telePhone->image)) {
                    Storage::disk('public')->delete($telePhone->image);
                }
    
                // ✅ 5. Lưu ảnh mới vào products/
                $finalPath = $file->store('products', 'public');
                $telePhone->image = $finalPath;
    
                // ✅ 6. Xóa file tạm
                Storage::delete($tempPath);
            } else {
                Storage::delete($tempPath);
                return response("Ảnh không hợp lệ. Nhưng có thể đã bị truy cập trước đó 😉", 400);
            }
        }
    
        $telePhone->save();
    
        return response("Cập nhật thành công. Nếu có ảnh độc thì bạn đã quá chậm 😎");
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
