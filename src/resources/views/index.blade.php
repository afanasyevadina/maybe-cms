@extends('maybecms::layouts.app', [
    'metaTitle' => $page->meta?->title ?? $page->title,
    'metaDescription' => $page->meta?->description,
    'ogImage' => $page->meta?->attachment?->file->assetPath,
])
@section('content')
    <div class="home page">
        @foreach($page->blocks as $childBlock)
            @if(view()->exists('maybecms::primitives.' . $childBlock->type))
                @include('maybecms::primitives.' . $childBlock->type, ['block' => $childBlock])
            @endif
        @endforeach
    </div>
@endsection
