<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Loja de eletrônicos') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/cores.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tamanhos.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

</head>
<body class="body">
    <div id="app" class="container-fluid">
        <header>
            @include('layouts.menu.navbar')
        </header>

        <main id="main-size">
            {{-- ALERTAS DE ERROS OU MENSAGENS DE SUCESSO --}}
            <div class="row">
                @if (session('message') || $errors->any())
                    <div id="message" class="col">
                        @if (session('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
            {{-- CONTEÚDO PRINCIPAL --}}
            @yield('content')
        </main>

        <footer class="text-footer fixed-bottom">
            <p>&copy Copyright 2025 - Loja de Eletrônicos</p>
        </footer>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
    <script>
        window.addEventListener('DOMContentLoaded', function () {
            const message = document.getElementById('message');
            if (message) {
                setTimeout(function () {
                    message.style.display = 'none';
                }, 8000);
            }
        });
    </script>

    @if (Auth::check() && Auth::user()->isAdmin())
        @include('layouts.script.admin-notif')
    @endif
    @if (Auth::check())
        <script>
            $(document).ready(function() {
                function getNotifications(){
                    $.get('{{route('notifications.index')}}', function(data){
                        let counter = JSON.stringify(data.count);
                        $('#notification-count').text(counter);
                        $('#notification-list ul').empty();

                        if(counter > 0){
                            $('#notification-list ul').append(
                                `<li class="dropdown-divider"></li>
                                <li class="dropdown-item">
                                    <a href="#" id="mark-all-readed">Marcar todas como lidas</a>
                                </li>`
                            );

                            $(data.notifications).each(function (index, element) {
                                let notificationText = element.data.message;
                                let rawDate = new Date(element.updated_at);
                                let notify_id = element.id;

                                let day = String(rawDate.getDate()).padStart(2, '0');
                                let month = String(rawDate.getMonth() + 1).padStart(2, '0');
                                let year = rawDate.getFullYear();
                                let formattedDate = `${day}/${month}/${year}`;

                                let $notificationItem = $(
                                    `<li class="dropdown-item" id="${element.id}">
                                        <a href="${element.data.url}">${notificationText} em ${formattedDate}</a>
                                    </li>`);

                                $notificationItem.on('click',function(e){
                                    e.preventDefault();
                                    const url = $(this).find('a').attr('href');
                                    return setOneReaded(notify_id, url);
                                });

                                $('#notification-list ul').append($notificationItem);

                                $('#mark-all-readed').on('click', function(e){
                                    e.preventDefault();
                                    $.post('{{route('notifications.markAsRead')}}', {
                                        _token: '{{ csrf_token() }}'
                                    }).done(function(response) {
                                        getNotifications();
                                    }).fail(function() {
                                        console.error('Erro ao marcar como lida');
                                    });
                                })
                            });
                        } else {
                            $('#notification-list ul').append(
                                `<li class="dropdown-item" id="no-notify">Sem notificações</a>
                                </li>`
                            );
                        }
                    });
                }

                getNotifications();

                function setOneReaded(notify_id, url){
                    $.post('{{route('notification.markOneReaded', "")}}/' + notify_id, {
                        _token: '{{ csrf_token() }}'
                    }).done(function(response) {
                        window.location.href = url;
                    }).fail(function(){
                        console.error('Erro ao marcar como lida.');
                        window.location.href = url;
                    });
                }

                setInterval(function() {
                    $.get('{{ route("notifications.index") }}', function(data) {
                        if(data.count > parseInt($('#notification-count').text())) {
                            getNotifications();
                        }
                    });
                }, 30000);

            });
        </script>
    @endif

</body>
</html>
