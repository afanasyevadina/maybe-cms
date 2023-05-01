@foreach($block->getPosts(@$source) as $post)
    <tr style="{{ $block->getProperty('css') }}">
        @foreach($block->blocks as $childBlock)
            @if(view()->exists('maybecms::primitives.' . $childBlock->type))
                @include('maybecms::primitives.' . $childBlock->type, ['block' => $childBlock, 'source' => $post, 'tag' => 'td'])
            @endif
        @endforeach
    </tr>
@endforeach
