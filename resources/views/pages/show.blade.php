@extends('layouts.app')
@section('title', $page->seo_title ?? $page->title)
@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-4">{{ $page->title }}</h1>
        {!! $page->content !!}
    </div>
@endsection
