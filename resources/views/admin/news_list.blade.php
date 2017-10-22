@extends('layouts.app')
@section('content')

    <div class="news-feed">
        @foreach($news as $item)
            <div class="news-item" data-item-id="{{$item->id}}">
                <div class="row admin-actions">
                    <div class="col-md-7 news-title">{{$item->title}}</div>
                    <div class="col-md-5 news-actions">
                        <div class="news-status">
                            @if($item->status==1)
                                <i class="fa fa-check text-success" aria-hidden="true"></i> Принято
                            @elseif($item->status==2)
                                <i class="fa fa-times text-danger" aria-hidden="true"></i> Отказано
                            @else
                                <i class="fa fa-pencil" aria-hidden="true"></i> В обработке
                            @endif

                        </div>
                        <div class="btn-group pull-right">
                            <button data-toggle="dropdown" type="button" class="btn btn-info btn-xs dropdown-toggle">

                                Действия<span class="caret"></span></button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{route('admin.news.payment')}}">Заплатить</a></li>
                                    <li><a href="#" class="accept" data-id="{{$item->id}}" {{$item->status==1?'style=display:none;':''}}>Принять</a></li>
                                    <li><a href="#" class="decline" data-id="{{$item->id}}" {{$item->status==2?'style=display:none;':''}}>Отказать</a></li>
                            </ul>
                        </div>
                    </div>

                </div>
                <div class="row news-content">
                    <div class="col-md-12">
                        {!! $item->content !!}
                    </div>
                </div>
            </div>
        @endforeach
        {!!  app('env')=== 'production'?str_replace("http://","https://",$news->links()):$news->links() !!}
    </div>
@endsection


@section('js')
    <img src="{{asset('img/wait.gif')}}" width="50px" height="50px" class="wait-gif" style="display: none;">
    <script>
        $('.news-feed').on('click', '.accept', function (e) {
            var loaded = true;
            $.ajax({
                type: "POST",
                url: '{{route('admin.news.ajax')}}',
                data: {
                    type: 'accept',
                    news_id: $(e.target).data('id')
                },
                dataType: 'json',
                success: function (data) {
                    if (data['code'] === 1) {
                        $('div[data-item-id="' + data['text']['id'] + '"] .news-status')[0].innerHTML = '<i class="fa fa-check text-success" aria-hidden="true"></i> Принято';
                        $('.accept[data-id="' + data['text']['id'] + '"]').css('display','none');
                        $('.decline[data-id="' + data['text']['id'] + '"]').css('display','');
                        console.log(data['text']);
                    } else {
                        console.error(data['text']);

                    }
                    $('.wait-gif').css('display', 'none');
                    loaded = true;
                },
                error: function (e, text) {
                    console.error(text);
                    $('.wait-gif').css('display', 'none');
                    loaded = true;
                }
            });
        });


        $('.news-feed').on('click', '.decline', function (e) {
            var loaded = true;
            $.ajax({
                type: "POST",
                url: '{{route('admin.news.ajax')}}',
                data: {
                    type: 'decline',
                    news_id: $(e.target).data('id')
                },
                dataType: 'json',
                success: function (data) {
                    if (data['code'] === 1) {
                        $('div[data-item-id="' + data['text']['id'] + '"] .news-status')[0].innerHTML = '<i class="fa fa-times text-danger" aria-hidden="true"></i> Отказано';
                        $('.accept[data-id="' + data['text']['id'] + '"]').css('display','');
                        $('.decline[data-id="' + data['text']['id'] + '"]').css('display','none');
                        console.log(data['text']);
                    } else {
                        console.error(data['text']);

                    }
                    $('.wait-gif').css('display', 'none');
                    loaded = true;
                },
                error: function (e, text) {
                    console.error(text);
                    $('.wait-gif').css('display', 'none');
                    loaded = true;
                }
            });
        });
    </script>
@endsection