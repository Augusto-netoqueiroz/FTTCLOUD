// public/js/ws-client.js
(function () {
  if (window.initWebSocket) return; // idempotente

  window.initWebSocket = function initWebSocket({ tenantId, authHeaders = {} }) {
    // Sanity
    if (!window.Echo) {
      // Criar instancia Echo
      window.Echo = new Echo({});
    }

    // Detecta driver
    var driver = (window.BROADCAST_DRIVER || 'pusher').toLowerCase();

    // Config comum
    var common = {
      authEndpoint: '/broadcasting/auth',
      csrfToken: document.querySelector('meta[name="csrf-token"]')?.content,
      auth: { headers: Object.assign({}, authHeaders) },
      enabledTransports: ['ws', 'wss']
    };

    if (driver === 'reverb') {
      // Reverb nativo
      window.Echo.connector.pusher = new Pusher(window.PUSHER_APP_KEY || 'reverb', {
        wsHost: window.WS_HOST || window.location.hostname,
        wsPort: Number(window.WS_PORT || 8080),
        wssPort: Number(window.WS_PORT || 8080),
        forceTLS: (window.WS_SCHEME || 'http') === 'https',
        disableStats: true,
        ...common
      });
    } else {
      // Pusher
      window.Pusher = window.Pusher || Pusher;
      window.Echo = new Echo({
        broadcaster: 'pusher',
        key: window.PUSHER_APP_KEY,
        cluster: window.PUSHER_APP_CLUSTER || 'mt1',
        wsHost: window.location.hostname,
        wsPort: 6001,     // ajuste conforme seu servidor WS
        forceTLS: false,
        disableStats: true,
        encrypted: false,
        ...common
      });
    }

    // Heartbeat opcional
    setInterval(function () {
      try {
        var ch = window.Echo.connector?.channels[`private-tenant.${tenantId}.users`];
        ch && ch.whisper && ch.whisper('heartbeat', { t: Date.now() });
      } catch (e) {}
    }, 30000);

    return window.Echo;
  };
})();
