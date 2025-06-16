<script src="https://js.pusher.com/4.3/pusher.min.js"></script>
@php
    $user = auth()->user();
@endphp

<script>
    const userId = {{ $user->id }};
    Pusher.logToConsole = true;
    var pusher = new Pusher('758b69f324903be2d901', {
        cluster: 'sa1',
    // forceTLS: true,
        authEndpoint: '/broadcasting/auth',
        auth: {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        }
    });

    var channel = pusher.subscribe('admins');
    channel.bind('new_order', function(data) {
        console.log(data);
        let notifCount = parseInt(document.getElementById('notification-count').innerText) || 0;
        notifCount++;
        document.getElementById('notification-count').innerText = notifCount;

        let dropItem = document.getElementById('notification-list');
        let newItem = document.createElement('li');
        let linkItem = document.createElement('a');

        linkItem.innerText = data.message;
        linkItem.href = 'orders';
        linkItem.style.textDecoration = 'none';

        let notif = document.getElementById('no-notify');
        notif.style.display = 'none';

        newItem.appendChild(linkItem);
        dropItem.prepend(newItem);
        alert(JSON.stringify(data));
    });
</script>
