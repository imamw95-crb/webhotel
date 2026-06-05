// Booking Modal State
var bm = {
    today: function() {
        return new Date().toISOString().split('T')[0];
    },
    tomorrow: function() {
        var d = new Date(); d.setDate(d.getDate() + 1);
        return d.toISOString().split('T')[0];
    },
    minCheckOut: function() {
        var ci = document.getElementById('bm-checkin').value;
        if (!ci) return bm.tomorrow();
        var d = new Date(ci); d.setDate(d.getDate() + 1);
        return d.toISOString().split('T')[0];
    },
    formatDate: function(dateStr) {
        if (!dateStr) return '';
        var parts = dateStr.split('-');
        return parts[2] + '/' + parts[1] + '/' + parts[0];
    },
    nights: function() {
        var ci = document.getElementById('bm-checkin').value;
        var co = document.getElementById('bm-checkout').value;
        if (!ci || !co) return 0;
        return Math.max((new Date(co) - new Date(ci)) / 86400000, 0);
    }
};

// Set min attributes on check-in and pre-fill defaults
function bmInitDates() {
    var ci = document.getElementById('bm-checkin');
    var co = document.getElementById('bm-checkout');
    if (ci) {
        ci.setAttribute('min', bm.today());
        if (!ci.value) ci.value = bm.today();
    }
    if (co) {
        co.setAttribute('min', bm.tomorrow());
        if (!co.value) co.value = bm.tomorrow();
    }
}

// Update check-out min when check-in changes
function bmUpdateCheckoutMin() {
    var ci = document.getElementById('bm-checkin');
    var co = document.getElementById('bm-checkout');
    if (ci && co) {
        co.setAttribute('min', bm.minCheckOut());
        if (co.value && co.value <= ci.value) co.value = '';
    }
}

// Update booking summary
function bmUpdateSummary() {
    var ci = document.getElementById('bm-checkin').value;
    var co = document.getElementById('bm-checkout').value;
    var summary = document.getElementById('bm-summary');
    if (ci && co) {
        document.getElementById('bm-sum-checkin').textContent = bm.formatDate(ci);
        document.getElementById('bm-sum-checkout').textContent = bm.formatDate(co);
        var n = bm.nights();
        document.getElementById('bm-sum-duration').textContent = n + (n > 1 ? ' nights' : ' night');
        summary.style.display = 'block';
    } else {
        summary.style.display = 'none';
    }
}

// Open modal
window.openBookingModal = function(options) {
    options = options || {};
    var modal = document.getElementById('booking-modal');
    if (!modal) return;

    // Set values
    if (options.checkIn) document.getElementById('bm-checkin').value = options.checkIn;
    if (options.checkOut) document.getElementById('bm-checkout').value = options.checkOut;
    if (options.guests) document.getElementById('bm-guests').value = options.guests;
    if (options.roomType) document.getElementById('bm-room-type').value = options.roomType;
    if (options.roomId) document.getElementById('bm-room-id').value = options.roomId;

    // Reset name/email/phone/notes/captcha
    document.getElementById('bm-name').value = '';
    document.getElementById('bm-email').value = '';
    document.getElementById('bm-phone').value = '';
    document.getElementById('bm-notes').value = '';
    var cap = document.getElementById('bm-captcha');
    if (cap) cap.value = '';

    // Init dates and show
    bmInitDates();
    bmUpdateCheckoutMin();
    bmUpdateSummary();
    modal.classList.remove('closing');
    modal.style.display = '';   // clear inline none from previous close
    // Force reflow so display change renders before adding 'open' class
    void modal.offsetWidth;
    modal.classList.add('open');
    document.body.style.overflow = 'hidden';
};

// Close modal with animation
function bmClose() {
    var modal = document.getElementById('booking-modal');
    if (!modal || modal.classList.contains('closing')) return;
    modal.classList.remove('open');
    modal.classList.add('closing');
    document.body.style.overflow = '';
    // After animation, hide fully
    var onEnd = function() {
        modal.classList.remove('closing');
        modal.style.display = 'none';
        modal.removeEventListener('transitionend', onEnd);
    };
    modal.addEventListener('transitionend', onEnd);
}

document.addEventListener('DOMContentLoaded', function() {
    // Close buttons
    document.getElementById('bm-close').addEventListener('click', bmClose);
    document.getElementById('bm-backdrop').addEventListener('click', bmClose);

    // ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') bmClose();
    });

    // Room card "Book Now" buttons
    document.querySelectorAll('.book-now-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            window.openBookingModal({
                checkIn: (document.getElementById('av-checkin') || {}).value || '',
                checkOut: (document.getElementById('av-checkout') || {}).value || '',
                guests: (document.getElementById('av-guests') || {}).value || 2,
                roomType: this.dataset.roomType || '',
                roomId: this.dataset.roomId || '',
            });
        });
    });

    // Format number to IDR
    function bmFormatPrice(num) {
        return 'Rp ' + Number(num).toLocaleString('id-ID');
    }

    // Calculate nights from dates
    function bmCalcNights(ci, co) {
        if (!ci || !co) return 0;
        return Math.max((new Date(co) - new Date(ci)) / 86400000, 0);
    }

    // Show skeleton loading while checking
    function bmShowSkeleton() {
        var container = document.getElementById('av-results');
        var iconEl = document.getElementById('av-results-icon');
        var titleEl = document.getElementById('av-results-title');
        var statusEl = document.getElementById('av-results-status');
        var typesContainer = document.getElementById('av-results-types');
        if (!container || !titleEl || !typesContainer) return;

        container.style.display = 'block';
        container.style.animation = 'none';
        void container.offsetWidth;
        container.style.animation = '';

        if (iconEl) {
            iconEl.className = 'av-icon loading';
            iconEl.innerHTML = '<i class="fa-solid fa-spinner"></i>';
        }
        titleEl.innerHTML = '<strong>Checking availability</strong><span style="color:var(--text-muted);font-size:13px;display:block;margin-top:2px;">Please wait a moment...</span>';
        if (statusEl) statusEl.textContent = '';

        // Build skeleton cards
        var skeletonHtml = '<div class="av-skeleton">';
        for (var i = 0; i < 4; i++) {
            skeletonHtml +=
                '<div class="av-skeleton-card">' +
                    '<div class="av-skeleton-shape av-skeleton-icon"></div>' +
                    '<div class="av-skeleton-lines">' +
                        '<div class="av-skeleton-shape av-skeleton-line"></div>' +
                        '<div class="av-skeleton-shape av-skeleton-line"></div>' +
                        '<div class="av-skeleton-shape av-skeleton-line"></div>' +
                    '</div>' +
                    '<div class="av-skeleton-shape av-skeleton-btn"></div>' +
                '</div>';
        }
        skeletonHtml += '</div>';
        typesContainer.innerHTML = skeletonHtml;
    }

    // Update availability results display
    function bmShowResults(rooms, checkIn, checkOut, guests) {
        var container = document.getElementById('av-results');
        var iconEl = document.getElementById('av-results-icon');
        var titleEl = document.getElementById('av-results-title');
        var statusEl = document.getElementById('av-results-status');
        var typesContainer = document.getElementById('av-results-types');
        if (!container || !titleEl || !typesContainer) return;

        var total = rooms.length;
        var nights = bmCalcNights(checkIn, checkOut);
        var dateStr = bm.formatDate(checkIn) + ' - ' + bm.formatDate(checkOut);

        // Group by room type
        var typeMap = {};
        rooms.forEach(function(r) {
            var key = r.room_type_name || 'Unknown';
            if (!typeMap[key]) {
                typeMap[key] = { name: key, rooms: [], price: r.price_per_night || 0 };
            }
            typeMap[key].rooms.push(r);
            var p = parseFloat(r.price_per_night || 0);
            if (p < typeMap[key].price || typeMap[key].price === 0) {
                typeMap[key].price = p;
            }
        });

        var typeKeys = Object.keys(typeMap);

        if (total === 0) {
            // ----- Empty State -----
            if (iconEl) {
                iconEl.className = 'av-icon empty';
                iconEl.innerHTML = '<i class="fa-solid fa-calendar-xmark"></i>';
            }
            titleEl.innerHTML = '<strong>No rooms available</strong><span style="color:var(--text-muted);font-size:13px;display:block;margin-top:2px;">' + dateStr + '</span>';
            if (statusEl) statusEl.textContent = '0 rooms';

            typesContainer.innerHTML =
                '<div class="av-empty">' +
                    '<div class="av-empty-icon"><i class="fa-solid fa-bed"></i></div>' +
                    '<div class="av-empty-title">Fully Booked</div>' +
                    '<div class="av-empty-desc">We couldn\'t find any available rooms for your selected dates. Try different dates or contact us directly for assistance.</div>' +
                    '<button type="button" class="btn-gold small" onclick="document.getElementById(\'av-search-btn\') ? document.getElementById(\'av-search-btn\').click() : null">' +
                        '<i class="fa-solid fa-rotate"></i> Try Different Dates' +
                    '</button>' +
                '</div>';
        } else {
            // ----- Results -----
            if (iconEl) {
                iconEl.className = 'av-icon success';
                iconEl.innerHTML = '<i class="fa-solid fa-check"></i>';
            }
            titleEl.innerHTML = '<strong>' + total + ' room' + (total > 1 ? 's' : '') + ' available</strong> ' +
                '<span class="highlight">' + dateStr + '</span>' +
                '<span style="color:var(--text-muted);font-size:13px;display:block;margin-top:2px;">' + nights + ' night' + (nights > 1 ? 's' : '') + '</span>';
            if (statusEl) statusEl.textContent = total + ' found';

            typesContainer.innerHTML = '';
            typeKeys.forEach(function(key) {
                var t = typeMap[key];
                var div = document.createElement('div');
                div.className = 'av-result-type';

                // Pick an icon based on room type name
                var iconName = 'bed';
                var nameLower = t.name.toLowerCase();
                if (nameLower.indexOf('suite') !== -1 || nameLower.indexOf('executive') !== -1) iconName = 'crown';
                else if (nameLower.indexOf('family') !== -1) iconName = 'people-group';
                else if (nameLower.indexOf('superior') !== -1) iconName = 'star';
                else if (nameLower.indexOf('deluxe') !== -1) iconName = 'gem';
                else if (nameLower.indexOf('president') !== -1 || nameLower.indexOf('royal') !== -1) iconName = 'crown';

                div.innerHTML =
                    '<div class="av-result-type-icon"><i class="fa-solid fa-' + iconName + '"></i></div>' +
                    '<div class="av-result-type-info">' +
                        '<div class="av-result-type-name">' + t.name + '</div>' +
                        '<div class="av-result-type-price">' + bmFormatPrice(t.price) + ' <small>/ night</small></div>' +
                        '<div class="av-result-type-count">' +
                            '<i class="fa-regular fa-door-open" style="margin-right:4px;"></i> ' + t.rooms.length + ' room' + (t.rooms.length > 1 ? 's' : '') +
                        '</div>' +
                    '</div>' +
                    '<button type="button" class="book-av-btn btn-gold small" data-room-type="' + t.name + '" data-room-id="">' +
                        '<i class="fa-solid fa-calendar-check"></i> Book' +
                    '</button>';
                typesContainer.appendChild(div);
            });

            // Attach event listeners to the new Book Now buttons
            typesContainer.querySelectorAll('.book-av-btn').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    window.openBookingModal({
                        checkIn: checkIn,
                        checkOut: checkOut,
                        guests: guests,
                        roomType: this.dataset.roomType || '',
                        roomId: this.dataset.roomId || '',
                    });
                });
            });
        }

        container.style.display = 'block';

        // Scroll to availability results
        var target = document.getElementById('av-results-section');
        if (!target) target = document.getElementById('rooms');
        if (target) {
            var nav = document.querySelector('nav');
            var h = nav ? nav.offsetHeight : 0;
            window.scrollTo({
                top: target.getBoundingClientRect().top + window.scrollY - h,
                behavior: 'smooth'
            });
        }
    }

    // Availability search button - call API then show results
    var searchBtn = document.getElementById('av-search-btn');
    if (searchBtn) {
        searchBtn.addEventListener('click', function(e) {
            e.preventDefault();
            var ci = (document.getElementById('av-checkin') || {}).value || '';
            var co = (document.getElementById('av-checkout') || {}).value || '';
            var g = (document.getElementById('av-guests') || {}).value || 2;

            if (!ci || !co) {
                alert('Please select both check-in and check-out dates.');
                return;
            }

            // Show loading state — preserve original HTML
            var searchBtnOrig = searchBtn.innerHTML;
            searchBtn.innerHTML = '<span class="bw-spinner" style="border-top-color:#09090f;border-color:rgba(0,0,0,0.15);"></span> Checking...';
            searchBtn.disabled = true;

            // Show skeleton in results area
            bmShowSkeleton();

            // Scroll to availability results
            var target = document.getElementById('av-results-section');
            if (!target) target = document.getElementById('rooms');
            if (target) {
                var nav = document.querySelector('nav');
                var h = nav ? nav.offsetHeight : 0;
                window.scrollTo({
                    top: target.getBoundingClientRect().top + window.scrollY - h,
                    behavior: 'smooth'
                });
            }

            // Call availability API (using key from .env via backend)
            var url = (window.bmApiUrl || '/api/check-availability') + '?check_in=' + encodeURIComponent(ci) + '&check_out=' + encodeURIComponent(co);

            fetch(url)
                .then(function(response) { return response.json(); })
                .then(function(result) {
                    searchBtn.innerHTML = searchBtnOrig;
                    searchBtn.disabled = false;

                    if (result.success && result.data) {
                        bmShowResults(result.data, ci, co, g);
                    } else {
                        bmShowResults([], ci, co, g);
                    }
                })
                .catch(function(err) {
                    searchBtn.innerHTML = searchBtnOrig;
                    searchBtn.disabled = false;
                    console.error('Availability check failed:', err);
                    bmShowResults([], ci, co, g);
                });
        });
    }
});
