this.addEventListener('install', function(event) {
});

this.addEventListener('fetch', function(event) {
  event.respondWith(fetch(event.request));
});