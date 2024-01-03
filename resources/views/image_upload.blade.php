<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>
<form action="{{ url('image_upload_confirm') }}" enctype="multipart/form-data" method="post">
{{ csrf_field() }}

ユーザー名:<div>{{ Auth::user()->name }}</div>
プロフィールアイコン：<br>
    <input type="file" name="image"><p>
    @if($errors->has('image'))
        @foreach($errors->get('image') as $message)
			{{ $message }}<br>
		@endforeach
    @endif
    <br>
    <input type="submit" value="アップロード">
</form>
</x-app-layout>