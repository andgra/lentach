@extends('layouts.app')
@section('content')
    <form method="post" action="{{route('user.news.store')}}" id="user_create_news">
        @include('common.messages', ['messages' => isset($messages)?$messages:[]])
        {{csrf_field()}}
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item active">
                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                   aria-controls="pills-home" aria-selected="true">Новость</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab"
                   aria-controls="pills-profile" aria-selected="false">Выплата</a>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade active in" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <div>
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
                            <input class="form-control" name="content_link" id="content_link"
                                   placeholder="вставьте ссылку" value="{{$news->content_link}}"/>
                        <textarea name="content_banner" id="content_banner"
                                  style="visibility: hidden; position: absolute;"></textarea>

                            <div class="row">
                                <div class="col-md-8" id="banner"></div>
                            </div>
                        </div>

                        <div id="content" style="display: none">
                        <textarea class="form-control" name="content_full"
                                  placeholder="содержание новости">{{$news->content_full}}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                <div class="form-group">
                    <label for="exampleInputEmail1">Счет на Яндекс.Деньги</label>
                    <input type="text" class="form-control" id="bill" name="bill" aria-describedby="emailHelp"
                           placeholder="Введите номер счета">
                </div>

            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-primary btn-lg" type="submit">Отправить</button>
        </div>
    </form>


@endsection

@section('js')
    <img src="{{asset('img/wait.gif')}}" width="50px" height="50px" class="wait-gif" style="display: none;">
    <script>
        $(function(){
            $("#pills-tab a").click(function (e) {
                e.preventDefault();
                $(this).tab('show');
            });

            var loaded_banner = true;
            $('#content_link').on('change', function () {
                trigger_change();
            });
            if ($('#content_link').val()) {
                trigger_change();
            }
            function trigger_change() {
                if (loaded_banner) {
                    loaded_banner = false;
                    $('.wait-gif').css('display', '');
                    $('#banner').empty();
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
                                $('#banner').append(data['text']);
                                $('#content_banner').text(data['text']);
                            } else if (data['code'] === 2) {
                                console.warn(data['text']);
                            } else {
                                console.error(data['text']);

                            }
                            $('.wait-gif').css('display', 'none');
                            loaded_banner = true;
                        },
                        error: function (e, text) {
                            console.error(text);
                            $('.wait-gif').css('display', 'none');
                            loaded_banner = true;
                        }
                    });
                }
            }
        });

    </script>
@endsection