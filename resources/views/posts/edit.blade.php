<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>CalendarEdit</title>
    </head>
    <body>
        <x-app-layout>
        <h1 class="title">CalendarEdit</h1>
        <div class="content"></div>
        <form action="/posts/{{ $post->id }}" method="POST">
            @csrf
            @method('PUT')
            <div class="content__title">
                <h2>Title</h2>
                <input type="text" name="post[title]" value="{{ $post->title }}"/>
            </div>
            <div class="content__body">
                <h2>Body</h2>
                <input type='text' name='post[body]' value="{{ $post->body }}">
            </div>
            <input type="submit" value="store"/>
        </form>
        <div class="back">
            [<a href="/">back</a>]
        </div>
        </x-app-layout>
    </body>
</html>