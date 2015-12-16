this.addEventListener('install', function(event) {
  event.waitUntil(
    caches.open('v1').then(function(cache) {
      return cache.addAll([
        'index.sw.html',
        '../../components/polymer/polymer-nano.html',
        'src/pica-view.html',
        'src/feed-service.html',
        'src/feed-data.html', 
        'src/grid-layout.html',
        'src/feed-view.html'
      ]);
    })
  );
});

var cachedFetch = function(request) {
  return caches.match(request).then(function(response) {
    if (response) {
      console.log('CACHE: got [' + request.url + ']');
      return response;
    }
    return fetch(request).then(function(response) {
      console.log('NETWORK: got [' + request.url + ']');
      return response;       
    }).catch(function(error) {
      console.error('fetch failed:', error);
      throw error;
    });
  });
};

this.addEventListener('fetch', function(event) {
  var request = event.request;
  /*
  if (event.request.url.split('/').pop() === 'index.sw.html') {
    request = new Request('index.sw.html');
    console.log('redirected request:', request.url);
  } else {
    console.log('standard request:', event.request.url);
  }
  */
  event.respondWith(cachedFetch(request));
});

