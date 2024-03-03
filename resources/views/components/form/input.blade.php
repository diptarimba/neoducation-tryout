@props([
    'value' => '',
    'name' => '',
    'label' => '',
    'type' => 'text',
    'placeholder' => '',
    'oninput' => '',
    'disable' => null,
    'accept' => '',
    'texting' => 'File',
])

<div>
    <div class="mb-4">
        @if (Str::lower($type) !== 'hidden')
            <label for="input-{{ $name }}"
                class="block font-medium text-gray-700 dark:text-gray-100 mb-2">{{ $label }}</label>
        @endif
        @if ($type == 'file')
        <label for="input-{{ $name }}"
                class="filename block hidden font-light text-gray-700 dark:text-gray-100 mb-2">{{ $label }}</label>
            <input type="file" id="input-{{ $name }}" accept="{{ $accept }}" class="hidden"
                name="{{ $name }}" onchange="updateFileName(this)">
            <label for="input-{{ $name }}"
                class="btn text-violet-500 hover:text-white border-violet-500 hover:bg-violet-600 hover:border-violet-600 focus:bg-violet-600 focus:text-white focus:border-violet-600 focus:ring focus:ring-violet-500/30 active:bg-violet-600 active:border-violet-600">Choose
                {{ $texting }}</label>
        @else
            <input {{ $disable !== "" && $disable !== null ? 'readonly' : '' }} oninput="{{ $oninput }}" name="{{ $name }}"
                id="input-{{ $name }}"
                class="w-full rounded border-gray-100 placeholder:text-sm focus:border focus:border-violet-500 focus:ring-0 dark:bg-zinc-700/50 dark:border-zinc-600 dark:placeholder:text-zinc-100 dark:text-zinc-100"
                type="{{ $type }}" placeholder="{{ $placeholder }}" value="{{ $value }}">
        @endif
    </div>
</div>

@push('additional-footer')
    <script>
        function updateFileName(input) {
            if (input.files && input.files[0]) {
                const fileName = input.files[0].name;
                const label = input.parentElement.querySelector('.filename');
                label.textContent = `File: ${fileName}`;
                label.classList.remove('hidden');
            }
        }
    </script>
@endpush
