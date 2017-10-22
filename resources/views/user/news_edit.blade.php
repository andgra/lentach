@extends('layouts.app')
@section('content')
    <div>
        <form method="post" action="{{route('user.news.edit', $news->id)}}" id="user_create_news">
            @include('common.messages', ['messages' => isset($messages)?$messages:[]])
            {{csrf_field()}}
            <div>
                <label for="title">Заголовок</label>
                <input class="form-control" type="text" name="title" id="title" value="{{$news->title}}"
                       required="required"/>
            </div>
            <div class="radio">
                <label class="radio-inline">
                    <input type="radio" name="is_link" value="1"
                           id="is_link_1" {{(!empty($news->is_link) && $news->is_link!="1")?'':'checked="checked"'}}/>Ссылка
                    на источник
                </label>
                <label class="radio-inline">
                    <input type="radio" name="is_link" value="0"
                           id="is_link_0" {{$news->is_link==="0"?'checked="checked"':''}}/>Ввод вручную
                </label>

                <div></div>
            </div>
            <div class="form-group">
                <div id="content_link_container">
                    <input class="form-control" name="content_link" id="content_link" placeholder="вставьте ссылку"
                           required="required" value="{{$news->content_link}}"/>
                    <textarea name="content_banner" id="content_banner"
                              style="visibility: hidden; position: absolute;"></textarea>
                </div>

                <div id="content" style="display: none">
                    <textarea class="form-control" name="content_full"
                              placeholder="содержание новости">{{$news->content_full}}</textarea>
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-primary btn-lg" type="submit">Сохранить</button>
            </div>
        </form>
    </div>

@endsection

@section('js')
    <img src="{{asset('img/wait.gif')}}" width="50px" height="50px" class="wait-gif" style="display: none;">
    <script>
        var loaded_banner = true;
        $('#content_link').on('change', function () {
            trigger_change();
        });
        if($('#content_link').val()) {
            trigger_change();
        }
        function trigger_change() {
            loaded_banner = false;
            $('.wait-gif').css('display','');
            $('#content_link_container .news').remove();
            $('#content_banner').empty();
            $.ajax({
                type: "POST",
                url: '{{route('api.v1.og')}}',
                data: {
                    url: $("#content_link").val()
                },
                dataType: 'json',
                success: function (data) {
                    if (data['code'] === 1) {
                        console.log(data['text']);
                        $('#content_link_container').append(data['text']);
                        $('#content_banner').text(data['text']);
                    } else if(data['code'] === 2){
                        console.warn(data['text']);
                    } else {
                        console.error(data['text']);

                    }
                    $('.wait-gif').css('display','none');
                    loaded_banner = true;
                },
                error: function (e, text) {
                    console.error(text);
                    $('.wait-gif').css('display','none');
                    loaded_banner = true;
                }
            });
        }
    </script>
@endsection