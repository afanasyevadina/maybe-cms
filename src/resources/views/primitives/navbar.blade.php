<div
    class="navbar {{ $block->getProperty('background') }}" style="{{ $block->getProperty('css') }}"
>
    <a href="/" class="navbar-brand">
        @if($attachment = $block->getAttachment('logo', @$source))
            <img src="{{ $attachment->file->assetPath }}" alt="{{ $block->getProperty('text') ?? 'logo' }}" class="navbar-logo">
        @endif
        <div class="navbar-title">{{ $block->getProperty('text', @$source) ?? '' }}</div>
    </a>
    @foreach($block->blocks as $childBlock)
        @if(view()->exists('maybecms::primitives.' . $childBlock->type))
            @include('maybecms::primitives.' . $childBlock->type, ['block' => $childBlock])
        @endif
    @endforeach
</div>
