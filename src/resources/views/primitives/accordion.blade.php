@foreach($block->getPosts(@$source) as $post)
    <div class="accordion">
        <a href="#" class="accordion-title">{{ $block->getProperty('title', $post) }}</a>
        <div class="accordion-content">
            @foreach($block->blocks as $childBlock)
                @if(view()->exists('maybecms::primitives.' . $childBlock->type))
                    @include('maybecms::primitives.' . $childBlock->type, ['block' => $childBlock, 'source' => $post])
                @endif
            @endforeach
        </div>
    </div>
@endforeach
