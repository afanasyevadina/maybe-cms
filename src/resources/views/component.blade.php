@extends('maybecms::layouts.app', [
    'metaTitle' => $component->title,
])
@section('content')
    <div class="page post">
        @foreach($component->blocks as $childBlock)
            @if(view()->exists('maybecms::primitives.' . $childBlock->type))
                @include('maybecms::primitives.' . $childBlock->type, ['block' => $childBlock])
            @endif
        @endforeach
    </div>
@endsection
