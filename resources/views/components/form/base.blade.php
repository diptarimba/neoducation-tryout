@props(['unique' => '', 'url' => '', 'method' => ''])
<form id="form{{$unique}}" action="{{ $url }}" method="{{ $method }}" enctype="multipart/form-data">
    @csrf
    @if (Str::endsWith(request()->route()->getName(),
            '.edit'))
        @method('PUT')
        {{-- Your content for edit route --}}
    @endif

    <div class="grid grid-cols-12 gap-5">
        <div class="col-span-12 lg:col-span-6">
            {{ $slot }}
        </div>
    </div>
</form>
