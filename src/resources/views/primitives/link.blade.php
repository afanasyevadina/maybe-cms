<a
    href="{{ $block->getProperty('url', @$source) }}"
    class="link {{ $block->getProperty('style') }}"
    style="{{ $block->getProperty('css') }}"
    target="{{ $block->getProperty('target') }}"
>
    {{ $block->getProperty('text', @$source) ?? $block->title }}
</a>
