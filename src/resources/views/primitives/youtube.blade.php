@php
$url = $block->getProperty('url');
$parsedUrl = parse_url($url);
$videoId = $parsedUrl['path'];
if (@$parsedUrl['query']) {
    parse_str($parsedUrl['query'], $queryArray);
    $videoId = @$queryArray['v'] ?? $videoId;
}
@endphp
<iframe style="width: 100%; aspect-ratio: 16 / 9" src="https://www.youtube.com/embed/{{ $videoId }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
