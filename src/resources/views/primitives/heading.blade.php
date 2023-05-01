<{{ $block->getProperty('level') ?? 'h1' }} class="heading {{ $block->getProperty('align') }}" style="{{ $block->getProperty('css') }}">
{!! nl2br($block->getProperty('text', @$source)) !!}
</{{ $block->getProperty('level') ?? 'h1' }}>
