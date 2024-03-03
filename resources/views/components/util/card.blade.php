@props(['add' => false, 'title' => '', 'url' => '', 'customText' => 'Add Data', 'customBtn' => null])
<div class="grid grid-cols-1">
    <div class="card dark:bg-zinc-800 dark:border-zinc-600">
        <div class="card-body pb-0">
            @if (!$add)
                <div class="flex justify-between">
                    <h6 class="mb-1 text-15 text-gray-700 dark:text-gray-100">{{ $title }}</h6>
                    <div class="flex justify-end">
                        {{ $customBtn }}
                    </div>

                </div>
            @else
                <div class="flex justify-between">
                    <h6 class="mb-1 text-15 text-gray-700 dark:text-gray-100">{{ $title }}</h6>
                    <div class="flex justify-end">
                        {{ $customBtn }}
                        <a href="{{ $url }}"><button
                                class="btn m-1 text-white bg-green-500 border-green-500 hover:bg-green-600 hover:border-green-600 focus:bg-green-600 focus:border-green-600 focus:ring focus:ring-green-500/30 active:bg-green-600 active:border-green-600">{{ $customText }}</button></a>
                    </div>

                </div>
            @endif
        </div>
        <div class="card-body">
            {{ $slot }}
        </div>

    </div>
</div>
