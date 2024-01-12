@props(['title' => '', 'data' => [], 'name' => '', 'value' => '', 'disable' => null])
<div class="mb-4">
    <div class="mb-3">
        <label class="block font-medium text-gray-700 dark:text-zinc-100 mb-2">{{ $title }}</label>
        <select {{$disable ? 'disabled' : ''}} name="{{ $name }}"
            class="dark:bg-zinc-800 dark:border-zinc-700 w-full rounded border-gray-100 py-2.5 text-sm text-gray-500 focus:border focus:border-violet-500 focus:ring-0 dark:bg-zinc-700/50 dark:text-zinc-100">
            <option>Select</option>
            @forelse (json_decode($data,1) as $eachKey => $each)
                <option {{ $value == $eachKey ? 'selected' : '' }} value="{{ $eachKey }}">{{ $each }}</option>
            @empty
                <option disabled>No options available</option>
            @endforelse
        </select>
    </div>
</div>
