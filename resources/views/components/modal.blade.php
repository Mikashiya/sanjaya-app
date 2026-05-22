<div id="modal_{{ $id }}" class="absolute inset-0 bg-black/70 hidden">
    <div class="absolute inset-5 bg-[#F6F6F6] rounded">
        <div class="w-full h-[10vh] flex justify-between items-center px-2 border-b border-gray-200">
            <p>{{ $title ?? '' }}</p>
            <button type="button" onclick="togglemodal('modal_{{ $id }}')" class="text-3xl mx-3">&times;</button>
        </div>
        <div class="w-full h-auto overflow-auto p-2 {{ $class ?? '' }}">
            {{ $slot }}
        </div>
    </div>
</div>