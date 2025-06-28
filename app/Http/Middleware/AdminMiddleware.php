<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate; // Sử dụng facade Gate

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra quyền admin
        if (Gate::denies('is-admin')) {
            // Nếu không phải admin, chuyển hướng và thông báo lỗi
            return redirect()->route('user.index')->with('error', 'Bạn không có quyền truy cập vào trang này.');
        }

        return $next($request); // Nếu là admin, tiếp tục xử lý request
    }
}
