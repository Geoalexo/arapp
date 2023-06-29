<x-app-layout>
    @push('scripts')
        <script src="https://aframe.io/releases/1.0.4/aframe.min.js"></script>
        <script src="https://raw.githack.com/AR-js-org/AR.js/master/aframe/build/aframe-ar.js"></script>
    @endpush

    <a-scene embedded arjs>
        <a-marker
                type="pattern"
                url="{{ asset('storage/' . $sight->marker_pattern) }}"
                emitevents="{{ $sight->emit_events }}"

                @if ($sight->smooth)
                    smooth="{{ $sight->smooth }}"
                    smooth-count="{{ $sight->smooth_count }}"
                    smooth-tolerance="{{ $sight->smooth_tolerance }}"
                    smooth-threshold="{{ $sight->smooth_threshold }}"
                @endif
        >
            <a-entity
                    position="{{ implode(' ', $sight->position) }}"
                    rotation="{{ implode(' ', $sight->rotation) }}"
                    scale="{{ implode(' ', $sight->scale) }}"
                    gltf-model="{{ asset('storage/' . $sight->gltf_model) }}"
            ></a-entity>
        </a-marker>
        <a-entity camera></a-entity>
    </a-scene>
</x-app-layout>