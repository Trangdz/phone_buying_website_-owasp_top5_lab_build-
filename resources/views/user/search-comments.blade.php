@extends('layouts.user.app_user')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Tìm kiếm bình luận</h4>
                </div>
                <div class="card-body">
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('user.search-comments',$id) }}" class="mb-4">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" 
                                   value="" placeholder="Nhập từ khóa tìm kiếm...">
                            <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                        </div>
                    </form>

                    <!-- Search Results -->
                    @if(request('search'))
                        <div style="margin: 20px 0; font-size: 1.5rem; color: #a678c2;">
                            1 search results for '{{ request('search') }}'
                        </div>
                        <div id="search-result" style="display:none;">{{ request('search') }}</div>
                    @endif
                    @if(isset($comments))
                        <h5>Kết quả tìm kiếm:</h5>
                        @if(count($comments) > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Người bình luận</th>
                                            <th>Sản phẩm</th>
                                            <th>Nội dung</th>
                                            <th>Thời gian</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($comments as $comment)
                                        <tr>
                                            <td>{{ $comment->user_name }}</td>
                                            <td>{{ $comment->telephone_name }}</td>
                                            <td class="comment-content">{{ $comment->content }}</td>
                                            <td>{{ \Carbon\Carbon::parse($comment->created_at)->format('d/m/Y H:i') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info">
                                Không tìm thấy bình luận nào phù hợp.
                            </div>
                        @endif
                    @endif
                    <div class="text-center mt-5">
                        @if(isset($id))
                            <a href="{{ route('user.detail', $id) }}" class="btn btn-outline-dark">
                                ← Quay lại trang chi tiết
                            </a>
                        @else
                            <a href="/" class="btn btn-outline-dark">
                                ← Quay lại trang chủ
                            </a>
                        @endif
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
{{-- <script>
    function trackSearch(query) {
        document.write('<mg src="/resources/images/tracker.gif?searchTerms='+query+'">');
    }
    var query = (new URLSearchParams(window.location.search)).get('search');
    if(query) {
        trackSearch(query);
    }
</script> --}}
{{-- @section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.comment-content').forEach(function(el) {
        var encoded = el.textContent.trim();
        try {
            var decoded = atob(encoded).replaceAll('[x]', '<').replaceAll('[/x]', '>');
            el.innerHTML = decoded;
        } catch (e) {
            // Nếu không phải base64 hợp lệ thì bỏ qua
        }
    });
});
</script>

<pre style="background:#f8f8f8; border:1px solid #eee; padding:10px; margin-top:30px;">
&lt;script&gt;
function trackSearch(query) {
    var safe = query.replaceAll('[x]', '&lt;').replaceAll('[/x]', '&gt;');
    document.write('&lt;img src="/resources/images/tracker.gif?searchTerms=' + safe + '"&gt;');
}
var query = (new URLSearchParams(window.location.search)).get('search');
if(query) trackSearch(query);
&lt;/script&gt;
</pre>
<script>
function trackSearch(query) {
    try {
        var decoded = atob(query);
        var safe = decoded.replaceAll('[x]', '<').replaceAll('[/x]', '>');
        var result = document.createElement('div');
        result.innerHTML = safe;
        document.body.appendChild(result);
    } catch (e) {
        // Nếu không phải base64 hợp lệ thì bỏ qua
    }
}
var el = document.getElementById('search-result');
if(el) {
    var query = el.textContent.trim();
    if(query) trackSearch(query);
}
</script>
@endsection  --}}