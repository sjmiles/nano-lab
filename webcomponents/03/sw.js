this.addEventListener('install', function(event) {
  event.waitUntil(
    // TODO(sjmiles): flush the cache when a new worker is installed, 
    // mostly for easier testing
    caches.delete('v1').then(function() {
      caches.open('v1').then(function(cache) {
        // TODO(sjmiles): seed the cache with modules required for offline 
        // that may not be fetched by online app (due to bundling or laziness)
        return cache.addAll([
          'index.html',
          'service-worker.html',
          'nav-bar.html',
          'some-content.html'
        ]);
      })
    })
  );
});

this.addEventListener('online', function(event) {
  console.log('received online event');
  this.registration.showNotification('Online', {body: 'Online Achieved', tag: 'abe-says'});
});

// serviceworker's hook into network operations
this.addEventListener('fetch', function(event) {
  // in certain unusual situations, we may want to no-op
  // and let the default machinery handle the request
  if (shouldFetch(event.request)) {
    event.respondWith(smartFetch(event.request));
  }
});

var shouldFetch = function(request) {
  // at this time we implement no passthrough case
  return true;
}

var smartFetch = function(request) {
  // begin a fetch no matter what, to freshen the cache
  // TODO(sjmiles): should be smarter to save bandwidth (?)
  var fetchedResponse = cachedFetch(request);
  // return a cached response, or at least the fetch promise
  return caches.match(request).then(function(response) {
    return response || fetchedResponse;
  });
};

var cachedFetch = function(request) {
  return fetch(request).then(function(response) {
    maybeCache(request, response);
    return response;       
  }).catch(function(error) {
    throw error;
  });
};

var maybeCache = function(request, response) {
  var url = new URL(request.url);
  var module = url.pathname.split('/').pop();
  switch (module) {
    case 'index.html':
    case 'service-worker.html':
    case 'nav-bar.html':
    case 'some-content.html':
      // TODO(sjmiles): we don't require cloning if we are 
      // just freshening the cache, how expensive is it?
      var cacheable = response.clone();
      caches.open('v1').then(function(cache) {
        return cache.put(request, cacheable);
      });
      break;
  }
};