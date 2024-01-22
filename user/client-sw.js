const staticDevCoffee = "dev-coffee-site-v1"
const assets = [
  "/",
  "https://manager.shanagroup.net",
  "../assets/css/bootstrap.min.css",
  
  "../assets/css/now-ui-dashboard.css?v=1.3.0",
  "../assets/demo/demo.css",
  "//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css",
  "../assets/js/core/jquery.min.js",
  "../assets/js/core/popper.min.js",
  "../assets/js/core/bootstrap.min.js",
  "../assets/js/plugins/perfect-scrollbar.jquery.min.js",
  "../assets/js/plugins/chartjs.min.js",
  "../assets/js/plugins/bootstrap-notify.js",
  "../assets/js/now-ui-dashboard.min.js?v=1.3.0",
  "../assets/demo/demo.js",
  
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