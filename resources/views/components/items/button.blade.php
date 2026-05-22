<button onclick="{{ $onclick }}" type="{{ $type ?? '' }}" class="w-30 h-10 rounded-md hover:opacity-80 transition-all {{ $class ?? '' }}">
    <i class="{{ $icon ?? '' }}"></i>
    {{ $title ?? '' }}
</button>