@props(['url' => '#', 'label' => 'Cancel', 'color' => 'red'])
<a href="{{$url}}" class="btn text-white bg-{{$color}}-500 border-{{$color}}-500 hover:bg-{{$color}}-600 hover:border-{{$color}}-600 focus:bg-{{$color}}-600 focus:border-{{$color}}-600 focus:ring focus:ring-{{$color}}-500/30 active:bg-{{$color}}-600 active:border-{{$color}}-600">{{$label}}</a>
