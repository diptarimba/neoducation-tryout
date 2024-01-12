@props(['useP'=> null, 'title' => '', 'prefix' => '', 'counterValue' => '', 'suffix' => '', 'color' => '', 'valueChanged' => '', 'information' => ''])

<div class="card dark:bg-zinc-800 dark:border-zinc-600">
    <div class="card-body">
        <div>
            <div class="items-center">
                <span class="text-gray-700 dark:text-zinc-100">{{ $title }}</span>
                <h4 class="my-4 text-xl text-gray-800 dark:text-gray-100 ">
                    {{ $prefix }}
                    <span class="counter-value" data-target="{{ $counterValue }}">{{ $counterValue }}</span>
                    {{ $suffix }}
                </h4>
            </div>
        </div>
        @if ($useP)
        <div class="flex items-center">
            <span
                class="text-xs py-[1px] px-1 bg-{{ $color }}-50/60 text-{{ $color }}-500 rounded font-medium dark:bg-{{ $color }}-500/30">{{ $valueChanged }}</span>
            <span class="ltr:ml-1.5 rtl:mr-1.5 text-gray-700 text-13 dark:text-zinc-100">{{ $information }}</span>
        </div>
        @endif
    </div>
</div>
