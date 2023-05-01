<div class="text {{ $block->getProperty('margin') }} {{ $block->getProperty('align') }}" style="{{ $block->getProperty('css') }}">
    {!! nl2br($block->getProperty('text', @$source)) !!}
</div>
