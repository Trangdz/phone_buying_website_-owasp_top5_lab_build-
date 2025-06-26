@extends('layouts.app_admin') {{-- Hoặc layouts.admin tùy cấu trúc của bạn --}}

@section('title', 'Change password')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Change password</h4>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('admin.auth.change-password') }}" method="POST">
                @csrf
                @method('POST') {{-- Hoặc 'PUT' nếu cần --}}
                
                <div class="mb-3">
                    <label for="old_password" class="form-label fw-bold">Old password</label>
                    <input type="password" name="old_password" class="form-control" required>
                    @error('old_password')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="new_password" class="form-label fw-bold">New password</label>
                    <input type="password" name="new_password" class="form-control" required>
                    @error('new_password')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="new_password_confirmation" class="form-label fw-bold">Confirm new password</label>
                    <input type="password" name="new_password_confirmation" class="form-control" required>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('admin.index') }}" class="btn btn-outline-primary">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
