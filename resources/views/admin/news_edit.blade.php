@extends('layouts.app')
@section('content')
    <div>
        <form method="post" action="{{route('user.news.store')}}">
            @include('common.messages', ['messages' => isset($messages)?$messages:[]])
            {{csrf_field()}}
            <div>
                <label for="title">Яндекс кошелек</label>
                <input class="form-control" type="text" name="title" id="title" value="{{$news->title}}" required="required"/>
            </div>
            <div class="radio">
                <label class="radio-inline">
                    <input type="radio" name="is_link" value="1" id="is_link_1" {{(!empty($news->is_link) && $news->is_link!="1")?'':'checked="checked"'}}/>Ссылка на источник
                </label>
                <label class="radio-inline">
                    <input type="radio" name="is_link" value="0" id="is_link_0" {{$news->is_link==="0"?'checked="checked"':''}}/>Ввод вручную
                </label>

                <div></div>
            </div>
            <div class="form-group">
                <input class="form-control" name="content_link" id="content_link" placeholder="вставьте ссылку" required="required" value="{{$news->content_link}}"/>

                <div id="content" style="display: none">
                    <textarea class="form-control" name="content_full"
                              placeholder="содержание новости">{{$news->content_full}}</textarea>
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-primary btn-lg" type="submit">Отправить</button>
            </div>
        </form>
    </div>
@endsection