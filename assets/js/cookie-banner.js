(function () {
  'use strict';

  var STORAGE_KEY = 'kamprogram_cookie_consent_v1';

  var init = function () {
    var banner = document.getElementById('cookie-banner');
    var acceptBtn = document.getElementById('cookie-banner-accept');
    if (!banner || !acceptBtn) {
      return;
    }

    var stored = false;
    try {
      stored = !!window.localStorage.getItem(STORAGE_KEY);
    } catch (e) {
      stored = false;
    }
    if (stored) {
      return;
    }

    banner.hidden = false;

    acceptBtn.addEventListener('click', function () {
      try {
        window.localStorage.setItem(STORAGE_KEY, '1');
      } catch (e) {
        /* ignore */
      }
      banner.hidden = true;
    });
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
