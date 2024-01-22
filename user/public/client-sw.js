const staticDevCoffee = "dev-coffee-site-v1"
const assets = [
  
  "assets/css/bootstrap.min.css",
  "assets/css/owl.theme.default.css",
  "assets/css/owl.carousel.min.css",
  "assets/js/lib/jquery-3.5.1.min.js",
  "assets/js/lib/popper.min.js",
  "assets/js/lib/bootstrap.min.js",
  
  
]

self.addEventListener("install", installEvent => {
  installEvent.waitUntil(
    caches.open(staticDevCoffee).then(cache => {
      cache.addAll(assets)
    })
  )
});

self.addEventListener("fetch", fetchEvent => {
  fetchEvent.respondWith(
    caches.match(fetchEvent.request).then(res => {
      return res || fetch(fetchEvent.request)
    })
  )
})