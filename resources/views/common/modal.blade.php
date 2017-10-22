<div class="modal fade in {{$modal['class']??''}}" id="{{$modal['id']}}" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">?</span></button>
                <h4 class="modal-title">
                    @if (isset($modal['title']))
                        {{$modal['title']}}
                    @endif
                </h4>

            </div>
            <div class="modal-body">
                @if (isset($modal['body']))
                    {!! $modal['body']!!}
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                @if (isset($modal['action']))
                    <button type="button" class="btn btn-primary" id="modal-action">{{$modal['action']}}</button>
                @endif
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>