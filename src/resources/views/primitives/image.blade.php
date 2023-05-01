@if($attachment = $block->getAttachment('src', @$source))
    <div class="img-wrapper">
        <img class="img {{ $block->getProperty('rounds') }}" style="{{ $block->getProperty('css') }}"
             src="{{ $attachment?->file->assetPath }}"
             alt="{{ $block->getProperty('alt') }}">
    </div>
@endif
