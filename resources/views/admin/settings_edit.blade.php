@extends('layouts.app')
@section('content')
    <div>
        <form method="post" action="{{route('settings.edit',$settings->id)}}" id="settings_edit_form">
            @include('common.messages', ['messages' => isset($messages)?$messages:[]])
            {{csrf_field()}}
            <div>
                <label for="editor_bill">Лицевой счет ЯД </label>
                <input class="form-control" type="text" name="editor_bill" id="editor_bill"
                       value="{{$settings->editor_bill}}"/>
            </div>


            <ul id="myTab" class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#panel_hosts">Заблокированые домены</a></li>
                <li><a data-toggle="tab" href="#panel_words">Заблокированые слова</a></li>

            </ul>

            <div class="tab-content">
                <div id="panel_hosts" class="tab-pane fade in active">
                    <table class="table">
                        <tr>
                            <th>№</th>
                            <th>Домен</th>
                            <th>Блокировка до</th>
                            <th colspan="2">Операции</th>
                        </tr>
                        @foreach($host_lists as $host_list)
                            <tr data-id="{{$host_list->id}}" data-type="host">
                                <td>{{$loop->iteration}}</td>
                                <td>{{$host_list->host->host}}</td>
                                <td>{{(new \Carbon\Carbon($host_list->expired_at))->toDateString()}}</td>
                                <td>
                                    <button type="button" class="btn btn-default btn-edit" title="Изменить">
                                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                    </button>
                                    <button type="button" class="btn btn-default btn-edit remove_news" data-toggle="modal"
                                            data-target="#myModalDelete" title="Удалить">
                                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div id="panel_words" class="tab-pane fade">

                    <table class="table">
                        <tr>
                            <th>№</th>
                            <th>Список слов</th>
                            <th>Блокировка до</th>
                            <th colspan="2">Операции</th>
                        </tr>
                        @foreach($word_lists as $word_list)
                            <tr data-id="{{$word_list->id}}" data-type="words">
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    @foreach($word_list->words as $word){{$word->word.(!$loop->last?';':'')}}@endforeach
                                </td>
                                <td>{{(new \Carbon\Carbon($word_list->expired_at))->toDateString()}}</td>
                                <td>
                                    <button type="button" class="btn btn-default btn-edit" title="Изменить">
                                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                    </button>
                                    <button type="button" class="btn btn-default btn-edit remove_news" data-toggle="modal"
                                            data-target="#myModalDelete" title="Удалить">
                                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-primary btn-lg" type="submit">Сохранить</button>
            </div>
        </form>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            function getTr(el) {
                while(!$(el).hasClass('btn-edit') && !$(el).hasClass('btn-save') && !$(el).hasClass('btn-delete'))
                    el=el.parentNode;
                console.log(el);
                return $(el.parentNode.parentNode);
            }
            $('table').on('click', '.btn-edit', function (ev) {
                var el = ev.target;
                var $tr=getTr(el);
                var id=$tr.data('id');
                var type=$tr.data('type');
                var $tds=$tr.children();

                $($tds[1]).html('<input type="text" class="form-control" name="title" data-id="'+id+'" data-type="'+type+'" value="'+$tds[1].innerText+'" />');
                $($tds[2]).html('<input type="date" class="form-control" name="expired_at" data-id="'+id+'" data-type="'+type+'" value="'+$tds[2].innerText+'" />');
                $('tr[data-id="'+id+'"][data-type="'+type+'"] .btn-edit').html('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>').removeClass('btn-edit').addClass('btn-save');
            });
            $('table').on('click', '.btn-save', function (ev) {
                var el = ev.target;
                var $tr=getTr(el);
                var id=$tr.data('id');
                var type=$tr.data('type');
                var $tds=$tr.children();

                $.ajax({
                    type: "POST",
                    url: '{{route('settings.ajax')}}',
                    data: {
                        type: 'save',
                        list_id: $tr.data('id'),
                        type_list: $tr.data('type'),
                        title: $('input[name="title"][data-id="'+id+'"][data-type="'+type+'"]').val(),
                        expired_at: $('input[name="expired_at"][data-id="'+id+'"][data-type="'+type+'"]').val(),
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (data['code'] === 1) {
                            console.log(data['text']);
                            alert('Запись изменена!');
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

                $($tds[1]).html('<input type="text" class="form-control" id="title_'+id+'" value="'+$tds[1].innerText+'" />');
                $($tds[2]).html('<input type="date" class="form-control" id="expired_at_'+id+'" value="'+$tds[2].innerText+'" />');
                $('tr[data-id="'+id+'"][data-type="'+type+'"] .btn-edit').html('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>').removeClass('btn-edit').addClass('btn-save');
            });
        });
    </script>
@endsection