@extends('maybecms::layouts.app', [
    'metaTitle' => $post->meta?->title ?? $post->title,
    'metaDescription' => $post->meta?->description,
    'ogImage' => $post->meta?->attachment?->file->assetPath,
])
@section('content')
    <div class="page post">
        @foreach($post->blocks as $childBlock)
            @if(view()->exists('maybecms::primitives.' . $childBlock->type))
                @include('maybecms::primitives.' . $childBlock->type, ['block' => $childBlock, 'source' => $post])
            @endif
        @endforeach
    </div>
@endsection
