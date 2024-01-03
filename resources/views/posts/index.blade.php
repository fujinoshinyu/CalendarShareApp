<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>CalendarShareApp</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <x-app-layout>
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('This is HOME') }}
                </h2>
            </x-slot>
            
            <p>Current User</p>
            <div>{{ Auth::user()->name }}</div>
            
            <div id='calendar'></div>
            <style scoped>
                #calendar{
                    height: 600px;
                    width: 900px;
                    padding: 30px;
                }
            </style scoped>
            
            
        <a href='/posts/create'>create</a>
        <div class='posts'>
            @foreach ($posts as $post)
                <div class='post'>
                    <h2 class='title'>
                        <a href="/posts/{{ $post->id }}">{{ $post->title }}</a>
                    </h2>
                    <p class='body'>{{ $post->body }}</p>
                </div>
                <form action="/posts/{{ $post->id }}" id="form_{{ $post->id }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="deletePost({{ $post->id }})">delete</button>
                </form>
                <script>
                    function deletePost(id) {
                    'use strict'
                    if (confirm('Once deleted, it cannot be restored.\nDo you really want to delete this?'))
                    { document.getElementById(`form_${id}`).submit();
                    } }
                </script>
                <a href="/categories/{{ $post->category->id }}">{{ $post->category->name }}</a>
            @endforeach
          </div>
          <div class='paginate'>
              {{ $posts->links() }}
          </div>
        </x-app-layout>
      </body>
  </html>