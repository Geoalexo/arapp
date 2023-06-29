@props([
    'slug',
    'marker_image',
])

<div class="object-contain flex relative justify-center items-center">
    <img src="data:image/svg+xml;utf8,{{ rawurlencode(QrCode::size(512)->margin(1)->generate(route('sights.show', $slug))) }}" alt="QR Code">
    <img class="w-16 h-16 absolute" src="{{ asset('storage/' . $marker_image) }}" alt="Marker"/>
</div>