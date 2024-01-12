<li>
    <a href="{{$url}}" aria-expanded="false" class="nav-menu pl-6 pr-4 py-3 block text-sm font-medium text-gray-700 transition-all duration-150 ease-linear hover:text-violet-500 dark:text-gray-300 dark:active:text-white dark:hover:text-white">
        <i data-feather="{{$icon}}"></i>
        <span data-key="{{$key}}"> {{$title}}</span>
    </a>
    <ul>
        {{$slot}}
    </ul>
</li>
