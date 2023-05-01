@foreach($block->getPosts(@$source) as $post)
    <a href="{{ $block->getProperty('url', $post) }}" class="card" style="{{ $block->getProperty('css') }}">
        @foreach($block->blocks as $childBlock)
            @if(view()->exists('maybecms::primitives.' . $childBlock->type))
                @include('maybecms::primitives.' . $childBlock->type, ['block' => $childBlock, 'source' => $post])
            @endif
        @endforeach
    </a>
@endforeach
