(function () {
    function clamp(value, min, max) {
        return Math.min(max, Math.max(min, value));
    }

    function applyChurchMeetViewHelpers() {
        document.querySelectorAll('[data-progress-width]').forEach(function (element) {
            var value = parseFloat(element.getAttribute('data-progress-width') || '0');
            if (Number.isFinite(value)) {
                element.style.width = clamp(value, 0, 100) + '%';
            }
        });

        document.querySelectorAll('[data-ring-angle]').forEach(function (element) {
            var value = parseFloat(element.getAttribute('data-ring-angle') || '0');
            if (Number.isFinite(value)) {
                element.style.setProperty('--ring', clamp(value, 0, 360) + 'deg');
            }
        });

        document.querySelectorAll('[data-brand-primary], [data-brand-rgb]').forEach(function (element) {
            var brandPrimary = element.getAttribute('data-brand-primary');
            var brandRgb = element.getAttribute('data-brand-rgb');

            if (brandPrimary) {
                element.style.setProperty('--brand-primary', brandPrimary);
            }

            if (brandRgb) {
                element.style.setProperty('--brand-rgb', brandRgb);
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', applyChurchMeetViewHelpers);
        return;
    }

    applyChurchMeetViewHelpers();
})();