<thead>
<tr style="{{ $block->getProperty('css') }}">
    @foreach($block->blocks as $childBlock)
        @if(view()->exists('maybecms::primitives.' . $childBlock->type))
            @include('maybecms::primitives.' . $childBlock->type, ['block' => $childBlock, 'source' => @$source, 'tag' => 'th'])
        @endif
    @endforeach
</tr>
</thead>
