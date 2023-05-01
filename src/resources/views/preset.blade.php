@extends('maybecms::layouts.app', [
    'metaTitle' => $preset->title,
])
@section('content')
    <div class="page post">
        @foreach($preset->blocks as $childBlock)
            @if(view()->exists('maybecms::primitives.' . $childBlock->type))
                @include('maybecms::primitives.' . $childBlock->type, ['block' => $childBlock])
            @endif
        @endforeach
    </div>
@endsection
