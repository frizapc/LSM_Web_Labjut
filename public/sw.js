const CACHE_NAME = "offline-v1";

const filesToCache = [
    "/",
    "/offline.html",
    "/css/bootstrap.min.css",
    "/icons/bootstrap-icons.min.css",
    "/js/bootstrap.bundle.min.js",
    "/css/app.min.css",
];

// Install: cache asset statis
self.addEventListener("install", function (event) {
    event.waitUntil(
        caches.open(CACHE_NAME).then(function (cache) {
            return cache.addAll(filesToCache);
        })
    );
});

// ✅ Activate: hapus cache versi lama
self.addEventListener("activate", function (event) {
    const cacheAllowlist = [CACHE_NAME];
    event.waitUntil(
        caches.keys().then(function (cacheNames) {
            return Promise.all(
                cacheNames.map(function (cacheName) {
                    if (!cacheAllowlist.includes(cacheName)) {
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
});

// Fetch: Network First untuk HTML, Cache First untuk lainnya
self.addEventListener("fetch", function (event) {
    const request = event.request;

    // Abaikan permintaan non-HTTP (misalnya chrome-extension://)
    if (!request.url.startsWith("http")) return;

    // Untuk HTML pages → Network First
    if (request.headers.get("accept")?.includes("text/html")) {
        event.respondWith(
            fetch(request)
                .then((response) => {
                    // Simpan ke cache
                    return caches.open(CACHE_NAME).then((cache) => {
                        cache.put(request, response.clone());
                        return response;
                    });
                })
                .catch(() => {
                    // Jika gagal, ambil dari cache
                    return caches.match(request).then((cached) => {
                        return cached || caches.match("/offline.html");
                    });
                })
        );
    } else {
        // Untuk asset lainnya → Cache First
        event.respondWith(
            caches.match(request).then((cachedResponse) => {
                if (cachedResponse) {
                    return cachedResponse;
                }

                return fetch(request)
                    .then((networkResponse) => {
                        return caches.open(CACHE_NAME).then((cache) => {
                            cache.put(request, networkResponse.clone());
                            return networkResponse;
                        });
                    })
                    .catch(() => caches.match("/offline.html"));
            })
        );
    }
});
