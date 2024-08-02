Pusher.logToConsole = true;

var pusher = new Pusher('7e77cae29e31556c9216', {
    cluster: 'ap1',
    authEndpoint: '/login', // Your auth endpoint
    auth: {
        headers: {
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    }
});

// Subscribe to the presence channel
var channel = pusher.subscribe('presence-activeStatus');

channel.bind('pusher:subscription_succeeded', function(members) {
    console.log('Subscription succeeded:', members);
});

channel.bind('pusher:subscription_error', function(status) {
    console.error('Subscription error:', status);
});
