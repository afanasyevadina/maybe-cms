@foreach($block->getPosts(@$source) as $post)
    <div
        class="section
            {{ $block->getProperty('background') }}
            {{ $block->getProperty('width') }}
            {{ $block->getProperty('display') }}
            {{ $block->getProperty('rounds') }}
            {{ $block->getProperty('align-v') }}
            {{ $block->getProperty('align-h') }}"
        style="{{ $block->getProperty('css') }}"
    >
        @foreach($block->blocks as $childBlock)
            @if(view()->exists('maybecms::primitives.' . $childBlock->type))
                @include('maybecms::primitives.' . $childBlock->type, ['block' => $childBlock, 'source' => $post])
            @endif
        @endforeach
    </div>
@endforeach
