@extends('layouts.app')
@section('content')

<table class="table table-hover" style="">
    <thead>
    <tr>
        <th scope="col">id</th>
        <th scope="col">Заголовок новости</th>
        <th scope="col">Статус</th>
    </tr>
    </thead>
    <tbody>
    @foreach($news as $item)
        <tr>
            <td scope="row">{{$item->id}}</td>
            <td>
                @if($item->status==0)
                    <a href="{{route('user.news.edit',$item->id)}}">{{$item->title}} <i class="fa fa-pencil" aria-hidden="true"></i></a>
                @else
                    <a href="{{route('user.news.show',$item->id)}}">{{$item->title}}</a>
                @endif
            </td>
            <td>
                @if($item->status==1)
                    Принято <i class="fa fa-check text-success" aria-hidden="true"></i>
                @elseif($item->status==2)
                    Отказано <i class="fa fa-times text-danger" aria-hidden="true"></i>
                @else
                    В обработке
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection