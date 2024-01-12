@if (request()->routeIs('*.edit'))
<button type="button" class="btn text-white bg-sky-500 border-sky-500 hover:bg-sky-600 hover:border-sky-600 focus:bg-sky-600 focus:border-sky-600 focus:ring focus:ring-sky-500/30 active:bg-sky-600 active:border-sky-600" data-tw-toggle="modal" data-tw-target="#{{$id}}">{{$label}}</button>
@endif
