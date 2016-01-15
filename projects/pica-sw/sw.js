this.addEventListener('install', function(event) {
  event.waitUntil(
    caches.delete('v1').then(function() {
      caches.open('v1').then(function(cache) {
        return cache.addAll([
          'index.sw.html',
          '../../components/polymer/polymer-nano.html',
          '../../components/nano-elements/nano-serviceworker.html',
          '../../components/nano-elements/nano-import.html',
          'src/pica-view.html',
          'src/feed-data.html', 
          'src/feed-view.html',
          'src/article-view.html',
          'no-image.png',
          'topics.html'
        ]);
      })
    })
  );
});

this.addEventListener('fetch', function(event) {
  // TODO(sjmiles): returning nothing hands the request back to the UA to handle, this useful when
  // default behavior and `fetch` behavior diverge. I don't believe they are _supposed_ to diverge,
  // but there are potentially some bugs right now.
  // In particular, mixed-content requests originating from the UA (`event.request` specifically)
  // are honored by the UA for 'passive' content, but in my testing these create errors when
  // `fetch`ed from here. 
  // `shouldHandle` specificially returns false for insecure (`http`) requests so that we don't simply
  // 404 insecure CORS images.
  if (shouldHandle(event.request)) {
    event.respondWith(cachedFetch(possiblyRedirect(event.request)));
  }
});

var shouldHandle = function(request) {
  return new URL(request.url).protocol === 'https:';
};

var possiblyRedirect = function(request) {
  var url = new URL(request.url);
  if (url.pathname.split('/').pop() === 'index.sw.html') {
    request = new Request('index.sw.html');
    console.log('SW: redirected request:', request.url);
  }
  /*
  if (url.protocol === 'http:') {
    url.protocol = 'https:';
    request = new Request(url.href, {mode: 'no-cors'});
    console.log('SW: redirected request:', request.url);
  }
  */
  return request;
};

var cachedFetch = function(request) {
  return caches.match(request).then(function(response) {
    if (response) {
      //console.log('CACHE: got [' + request.url + ']');
      return response;
    } else {
      return fetch(request).then(function(response) {
        //console.log('NETWORK: got [' + request.url + ']');
        possiblyCache(request, response);
        return response;       
      }).catch(function(error) {
        //console.error('fetch failed:', error);
        throw error;
      });
    }
  });
};

var possiblyCache = function(request, response) {
  var type = responseType(request, response);
  if (type === 'image') {
    console.log('SW: NOCACHE [' + type + ']: ' + request.url);
  } else {
    var cacheable = response.clone();
    caches.open('v1').then(function(cache) {
      cache.put(request, cacheable);
      console.log('SW: cache [' + type + ']: ' + request.url);
    });
  }
};

var responseType = function(request, response) {
  // TODO(sjmiles): would like to type-sniff via MIME but headers always empty
  // @jakearchibald says: CORS restricts headers (unless server supplies `Access-Control-Allow-Headers`)
  console.log(response.headers);
  //var type = response.headers.get('Content-Type');
  //type = (type || '').split('/').shift();
  //
  // TODO(sjmiles): resort to extension-sniffing instead
  var type = '';
  var ext = new URL(request.url).pathname.split('/').pop().split('.').pop().toLowerCase();
  //
  switch(ext) {
    case 'jpg':
    case 'jpeg':
    case 'png':
    case 'gif':
      type = 'image';
      break;
  }
  return type;
};
