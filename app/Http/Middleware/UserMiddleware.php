<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate; // Sử dụng đúng facade Gate


class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        if(Gate::allows('is-admin')){
            // Nếu là admin, tiếp tục xử lý request
            return redirect()->route('admin.index')->with('error', 'Bạn không có quyền truy cập vào trang này.');
        }
        return $next($request);
    }
}
