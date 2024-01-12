@props(['message' => '', 'color' => ''])

<div class="mb-2 relative flex items-center px-5 py-2 border-2 text-{{$color}}-500 border-{{$color}}-200 rounded alert-dismissible">
    <p>{{$message}}</p>
    <button class="alert-close ltr:ml-auto rtl:mr-auto text-{{$color}}-400 text-lg"><i class="mdi mdi-close"></i></button>
</div>
