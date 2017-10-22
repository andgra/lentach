@foreach(
    !empty('only_messages')?array_merge(
        $messages,
        session('done')?[['type'=>'success','text'=>session('done')]]:[],
        $errors->any()?array_map(function($error) { return ['type'=>'error','text'=>$error]; },$errors->all()):[]
    ):$messages as $msg)

    <div class="alert alert-{{$msg['type']==='error'?'danger':$msg['type']}}">
        @isset($msg['title'])
        <div class="alert-title"><strong>{{ $msg['title'] }}</strong></div>
        @endisset

        {{ $msg['text'] }}
    </div>
@endforeach