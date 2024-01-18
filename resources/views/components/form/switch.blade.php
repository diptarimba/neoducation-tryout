@props(['label' => '', 'checked' => null, 'name' => ''])
<div class="mt-3">
    <label class="relative inline-flex items-center cursor-pointer">
        <input name="{{$name}}" type="checkbox" class="sr-only peer" {{(!$checked) ?: 'checked'}}>
        <div class="w-10 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] ltr:after:left-[2px] rtl:after:right-5 peer-checked:after:left-1.5 after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-zinc-600 peer-checked:bg-sky-500"></div>
        <span class="ltr:ml-3 rtl:mr-3 text-sm font-medium text-gray-700 dark:text-zinc-100">{{$label}}</span>
    </label>
</div>
