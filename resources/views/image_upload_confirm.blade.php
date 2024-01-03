<form action="{{ url('image_upload_complete') }}" method="post">
{{ csrf_field() }}
ユーザー名：{{ $name }}
    <input type="hidden" name="name" value="{{ $name }}">
<br>
プロフィール画像：<br>
    <img src="./../storage/app/{{ $image_path }}" alt="" width="40%">
    <input type="hidden" name="image_path" value="{{ $image_path }}">
    <input type="hidden" name="extension" value="{{ $extension }}"><br>
    <input type="submit" value="完了">
</form>
