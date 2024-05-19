const CACHE_NAME = "pwa-v" + new Date().getTime(); // Ganti dengan nama cache yang Anda inginkan

const resourcesToCache = [
    '/',
    '/css/app.css',
    '/js/app.js',
    '/assets/backend/stisla/css/style.css',
    '/assets/backend/stisla/css/components.css',
    '/assets/backend/stisla/modules/toastr/toastr.min.css',
    '/assets/backend/stisla/modules/bootstrap-social/bootstrap-social.css',
    '/assets/backend/stisla/modules/fontawesome/css/all.min.css',
    '/assets/backend/stisla/modules/bootstrap/css/bootstrap.min.css',
    '/assets/backend/stisla/modules/izitoast/css/iziToast.min.css',
    '/assets/backend/stisla/modules/jqvmap/dist/jqvmap.min.css',
    '/assets/backend/stisla/modules/nprogress/nprogress.css',
    '/assets/backend/stisla/modules/jquery.min.js',
    '/assets/backend/stisla/modules/popper.js',
    '/assets/backend/stisla/modules/tooltip.js',
    '/assets/backend/stisla/modules/bootstrap/js/bootstrap.min.js',
    '/assets/backend/stisla/modules/nicescroll/jquery.nicescroll.min.js',
    '/assets/backend/stisla/modules/moment.min.js',
    '/assets/backend/stisla/modules/nprogress/nprogress.js',
    '/assets/backend/stisla/js/stisla.js',
    '/assets/backend/stisla/js/ajaxHandler.js',
    '/assets/backend/stisla/modules/izitoast/js/iziToast.min.js',
    '/assets/backend/stisla/js/scripts.js',
    '/assets/backend/stisla/js/custom.js',
];

self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME).then(cache => {
            return cache.addAll(resourcesToCache);
        }).then(self.skipWaiting())
    );
});

self.addEventListener('fetch', event => {
    event.respondWith(
        fetch(event.request)
            .then(response => {
                const clonedResponse = response.clone();
                caches.open(CACHE_NAME).then(cache => {
                    cache.put(event.request, clonedResponse);
                });
                return response;
            }).catch(() => {
                return caches.match(event.request)
                    .then(cachedResponse => {
                        if (cachedResponse) {
                            return cachedResponse;
                        } else if (event.request.mode === 'navigate') {
                            return caches.match('/offline.html');
                        }
                    });
            })
    );
});

self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.map(cacheName => {
                    if (cacheName !== CACHE_NAME) {
                        return caches.delete(cacheName);
                    }
                })
            );
        }).then(() => self.clients.claim())
    );
});

// Tindak lanjuti permintaan dari halaman untuk menampilkan tombol instalasi
self.addEventListener('message', event => {
    if (event.data.action === 'displayInstallButton') {
        self.registration.showInstallPrompt();
    }
});

// Tangani proses instalasi PWA
self.addEventListener('appinstalled', event => {
    // Proses yang ingin dilakukan setelah aplikasi diinstal
    console.log('Aplikasi diinstal.');
});