<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Telephone;
use Illuminate\Http\Request;
use App\Models\ShoppingCart;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\returnCallback;

class ShoppingController extends Controller
{
    public function index(){
        
        $telephones=Telephone::all();
        return view('user.home',compact('telephones'));
    }
    public function detail($id){
        $telephone = Telephone::with('comments.user')->findOrFail($id);
        return view('user.detail', compact('telephone'));
    }

    public function order($id){
        $user = Auth::user();
        $cartItem = ShoppingCart::where('user_id', $user->id)
            ->where('telephone_id', $id)
            ->where('status', 'pending')
            ->first();
        if ($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            ShoppingCart::create([
                'user_id' => $user->id,
                'telephone_id' => $id,
                'quantity' => 1,
                'status' => 'pending',
            ]);
        }
        return redirect()->back()->with('success', 'Đã thêm vào giỏ hàng!');
    }


    public function history()
    {
        $id=Auth::user()->id;
        $histories=ShoppingCart::where('user_id',$id)
        ->where('status','paid')
        ->get();
        return view('user.history',compact('histories'));
    }

    public function pay(){
        $user = Auth::user();
        $cartItems = ShoppingCart::where('user_id', $user->id)
            ->where('status', 'pending')->get();
        $total = 0;
        foreach ($cartItems as $item) {
            $telephone = Telephone::find($item->telephone_id);
            $total += $telephone->price * $item->quantity;
        }
        if ($user->balance < $total) {
            return redirect()->back()->with('error', 'Số dư không đủ để thanh toán!');
        }
        // Trừ tiền
        $user->balance -= $total;
        $user->save();
        // Đánh dấu đã thanh toán
        foreach ($cartItems as $item) {
            $item->status = 'paid';
            $item->save();
        }
        return redirect()->back()->with('success', 'Thanh toán thành công!');
    }

    public function cart(){
        $user= Auth::user();
        $userBalance =  $user->balance;
        $cartItems = ShoppingCart::where('user_id', $user->id)
            ->where('status', 'pending')
            ->with('telephone')
            ->get();
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item->telephone->price * $item->quantity;
        }

        return view('user.cart', compact('cartItems', 'total','userBalance'));
    }

    public function addToCart(Request $request, $id){
        $user = Auth::user();
        $quantity = $request->input('quantity', 1);
        
        $cartItem = ShoppingCart::where('user_id', $user->id)
            ->where('telephone_id', $id)
            ->where('status', 'pending')
            ->first();
            
        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            ShoppingCart::create([
                'user_id' => $user->id,
                'telephone_id' => $id,
                'quantity' => $quantity,
                'status' => 'pending',
            ]);
        }
        return redirect()->back()->with('success', 'Đã thêm vào giỏ hàng!');
    }

    public function storeComment(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $user = Auth::user();
        
        Comment::create([
            'user_id' => $user->id,
            'telephone_id' => $id,
            'content' => $request->content,
        ]);

        // Redirect về trang detail với dữ liệu mới
        return redirect()->route('user.detail', $id)->with('success', 'Comment đã được thêm thành công!');
    }

    public function deleteComment($commentId)
    {
        $user = Auth::user();
        $comment = Comment::where('id', $commentId)
            ->where('user_id', $user->id)
            ->firstOrFail();
        
        $comment->delete();
        
        return redirect()->back()->with('success', 'Comment đã được xóa!');
    }

    public function searchComments(Request $request)
    {
        $search = $request->input('search', '');
        
        if (empty($search)) {
            $comments = [];
            return view('user.search-comments', compact('comments', 'search'));
        }
        
        // Lỗ hổng SQL Injection - sử dụng raw query không parameterized
        $query="
            SELECT c.*, u.name as user_name, t.name as telephone_name 
            FROM comments c 
            JOIN users u ON c.user_id = u.id 
            JOIN telephones t ON c.telephone_id = t.id 
            WHERE c.content LIKE '%{$search}%' 
            ORDER BY c.created_at DESC
        ";
        // dd($query);
        $comments = DB::select($query);
        
        return view('user.search-comments', compact('comments', 'search'));
    }

    public function getCommentsByUser(Request $request)
    {
        $userId = $request->input('user_id', '');
        
        if (empty($userId)) {
            $comments = [];
            return view('user.user-comments', compact('comments', 'userId'));
        }
        
        // Lỗ hổng SQL Injection - sử dụng raw query không parameterized
        // Thêm kiểm tra để tránh lỗi khi user_id không phải số
        if (!is_numeric($userId)) {
            $comments = [];
            return view('user.user-comments', compact('comments', 'userId'));
        }
        
        $comments = DB::select("
            SELECT c.*, u.name as user_name, t.name as telephone_name 
            FROM comments c 
            JOIN users u ON c.user_id = u.id 
            JOIN telephones t ON c.telephone_id = t.id 
            WHERE c.user_id = {$userId}
            ORDER BY c.created_at DESC
        ");
        
        return view('user.user-comments', compact('comments', 'userId'));
    }
}
