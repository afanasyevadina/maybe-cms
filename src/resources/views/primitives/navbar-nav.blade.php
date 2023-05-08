<div
    class="navbar-nav" style="{{ $block->getProperty('css') }}"
>
    <input type="checkbox" id="menu-check">
    <label for="menu-check" class="menu-toggler">
        <span></span>
        <span></span>
        <span></span>
    </label>
    <nav>
        @foreach($block->blocks as $childBlock)
            @if(view()->exists('maybecms::primitives.' . $childBlock->type))
                @include('maybecms::primitives.' . $childBlock->type, ['block' => $childBlock])
            @endif
        @endforeach
    </nav>
</div>
