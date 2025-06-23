@extends('layouts.app_admin')

@section('content')
<div class="container-fluid px-4">

    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $pageTitle ?? 'Users List' }}</h1>
        <a href="{{route('admin.telephones.add')}}" class="btn btn-primary">Add New TelePhone</a>
       
    </div>

    <!-- Table Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary text-white">
            <h6 class="m-0 font-weight-bold">Telephones List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="thead-light">
                        <tr>
                           
                            <th width="5%">No.</th>
                            <th>Name</th>
                          
                            <th>Number</th>
                            <th>Price</th>
                            <th width="8%">Edit</th>
                            <th width="8%">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($telephones->count() > 0)
                            @foreach ($telephones as $telephone)
                              <tr>
                                <td>{{ $loop->iteration }}</td> 
                                <td>{{$telephone->name}}</td>
                                <td>{{$telephone->number}}</td>
                                <td>{{$telephone->price}}</td>
                                
                                <td>
                                    <a href="{{ route('admin.telephones.edit', ['id' => $telephone->id]) }}" class="btn btn-primary btn-sm">Edit</a>
                                </td>
                                <td>
                                    <form action="{{ route('admin.telephones.delete', ['id' => $telephone->id]) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                                
                               </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center text-muted">No users found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

