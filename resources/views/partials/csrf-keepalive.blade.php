<script>
    (function () {
        const metaToken = document.querySelector('meta[name="csrf-token"]');
        if (!metaToken) {
            return;
        }

        const protectedMethods = new Set(['POST', 'PUT', 'PATCH', 'DELETE']);
        const refreshUrl = @json(route('session.token'));
        let lastActivityAt = Date.now();
        let lastRefreshAt = 0;
        let pendingRefresh = null;

        const protectedForms = () => Array.from(document.forms).filter((form) => {
            const method = (form.getAttribute('method') || 'GET').toUpperCase();
            return protectedMethods.has(method) || form.querySelector('input[name="_token"]');
        });

        if (protectedForms().length === 0) {
            return;
        }

        const applyToken = (token) => {
            if (!token) {
                return;
            }

            metaToken.setAttribute('content', token);

            document.querySelectorAll('input[name="_token"]').forEach((input) => {
                input.value = token;
            });
        };

        const refreshToken = (force = false) => {
            if (pendingRefresh) {
                return pendingRefresh;
            }

            if (!force && Date.now() - lastRefreshAt < 60000) {
                return Promise.resolve();
            }

            pendingRefresh = fetch(refreshUrl, {
                method: 'GET',
                credentials: 'same-origin',
                cache: 'no-store',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            })
                .then((response) => response.ok ? response.json() : null)
                .then((payload) => {
                    if (payload && payload.token) {
                        applyToken(payload.token);
                        lastRefreshAt = Date.now();
                    }
                })
                .catch(() => {})
                .finally(() => {
                    pendingRefresh = null;
                });

            return pendingRefresh;
        };

        const markActivity = () => {
            lastActivityAt = Date.now();
        };

        ['click', 'keydown', 'input', 'change', 'focus'].forEach((eventName) => {
            document.addEventListener(eventName, markActivity, true);
        });

        document.addEventListener('submit', (event) => {
            const form = event.target;
            if (!(form instanceof HTMLFormElement)) {
                return;
            }

            const method = (form.getAttribute('method') || 'GET').toUpperCase();
            if (!protectedMethods.has(method) && !form.querySelector('input[name="_token"]')) {
                return;
            }

            let tokenField = form.querySelector('input[name="_token"]');
            if (!tokenField) {
                tokenField = document.createElement('input');
                tokenField.type = 'hidden';
                tokenField.name = '_token';
                form.appendChild(tokenField);
            }

            tokenField.value = metaToken.getAttribute('content') || '';
        }, true);

        window.addEventListener('pageshow', (event) => {
            if (event.persisted) {
                refreshToken(true);
            }
        });

        document.addEventListener('visibilitychange', () => {
            if (document.visibilityState === 'visible') {
                refreshToken(true);
            }
        });

        setInterval(() => {
            if (document.visibilityState !== 'visible') {
                return;
            }

            if (Date.now() - lastActivityAt > 10 * 60 * 1000) {
                return;
            }

            refreshToken();
        }, 5 * 60 * 1000);
    })();
</script>
