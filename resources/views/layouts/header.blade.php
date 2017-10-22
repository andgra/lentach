<header class="row">
    <ul class="list-inline pull-right">
        {{--<li style="padding: 14px 15px;">({{$cUser->login}})</li>--}}
        <li class="list-inline-item">
            <a href="{{route('user.news.create')}}">Создать</a>
        </li>
        <li class="list-inline-item">
            <a href="{{route('user.news.index')}}">Список</a>
        </li>
        <li class="list-inline-item">
            <a href="{{route('admin.news.index')}}">Админ список</a>
        </li>
        <li class="list-inline-item">
            <a href="{{route('settings.edit',1)}}">Настройки</a>
        </li>
    </ul>
</header>