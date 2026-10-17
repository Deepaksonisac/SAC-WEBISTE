/* SAC theme behaviour: header, mobile menu, reveals, counters, accordions, filters, forms. */
(function () {
  'use strict';

  var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* Header shadow on scroll (home page starts flat). */
  var header = document.getElementById('sac-header');
  if (header && header.getAttribute('data-solid') === '0') {
    var onScroll = function () {
      header.classList.toggle('is-scrolled', window.scrollY > 24);
    };
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
  }

  /* Mobile menu */
  var panel = document.getElementById('sac-mobile-menu');
  var backdrop = document.querySelector('[data-sac-menu-backdrop]');
  var openBtn = document.querySelector('[data-sac-menu-open]');
  var closeBtn = document.querySelector('[data-sac-menu-close]');

  function setMenu(open) {
    if (!panel || !backdrop || !openBtn) return;
    openBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
    document.body.classList.toggle('sac-menu-locked', open);
    if (open) {
      panel.hidden = false;
      backdrop.hidden = false;
      requestAnimationFrame(function () {
        panel.classList.add('is-open');
        backdrop.classList.add('is-open');
        if (closeBtn) closeBtn.focus();
      });
    } else {
      panel.classList.remove('is-open');
      backdrop.classList.remove('is-open');
      setTimeout(function () {
        if (!panel.classList.contains('is-open')) {
          panel.hidden = true;
          backdrop.hidden = true;
        }
      }, 300);
    }
  }

  if (openBtn) openBtn.addEventListener('click', function () { setMenu(true); });
  if (closeBtn) closeBtn.addEventListener('click', function () { setMenu(false); openBtn.focus(); });
  if (backdrop) backdrop.addEventListener('click', function () { setMenu(false); });
  document.querySelectorAll('[data-sac-menu-link]').forEach(function (link) {
    link.addEventListener('click', function () { setMenu(false); });
  });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && panel && panel.classList.contains('is-open')) {
      setMenu(false);
      openBtn.focus();
    }
  });
  window.matchMedia('(min-width: 1024px)').addEventListener('change', function (mq) {
    if (mq.matches) setMenu(false);
  });

  /* Count-up animation for stats */
  function countUp(el) {
    var target = parseInt(el.getAttribute('data-sac-count'), 10) || 0;
    var suffix = el.getAttribute('data-suffix') || '';
    if (reduceMotion || target <= 0) {
      el.textContent = target + suffix;
      return;
    }
    var start = null;
    var duration = 1600;
    function step(ts) {
      if (start === null) start = ts;
      var p = Math.min((ts - start) / duration, 1);
      var eased = 1 - Math.pow(1 - p, 3);
      el.textContent = Math.round(target * eased) + suffix;
      if (p < 1) requestAnimationFrame(step);
    }
    el.textContent = '0' + suffix;
    requestAnimationFrame(step);
  }

  /* Scroll reveals + counters */
  var reveals = document.querySelectorAll('.sac-reveal');
  var counters = document.querySelectorAll('[data-sac-count]');
  if ('IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        var el = entry.target;
        if (el.hasAttribute('data-sac-count')) countUp(el);
        else el.classList.add('is-visible');
        io.unobserve(el);
      });
    }, { rootMargin: '0px 0px -60px 0px', threshold: 0.1 });
    reveals.forEach(function (el) { io.observe(el); });
    counters.forEach(function (el) { io.observe(el); });
  } else {
    reveals.forEach(function (el) { el.classList.add('is-visible'); });
  }

  /* Solutions accordion (opens automatically when linked via #anchor) */
  document.querySelectorAll('[data-sac-solution]').forEach(function (card) {
    var btn = card.querySelector('[data-sac-solution-toggle]');
    if (!btn) return;
    function setOpen(open) {
      card.classList.toggle('is-open', open);
      btn.setAttribute('aria-expanded', open ? 'true' : 'false');
      btn.setAttribute('aria-label', btn.getAttribute(open ? 'data-label-open' : 'data-label-closed'));
    }
    btn.addEventListener('click', function () { setOpen(!card.classList.contains('is-open')); });
    if (window.location.hash && card.id && window.location.hash.slice(1) === card.id) setOpen(true);
  });

  /* Project industry filter */
  var grid = document.querySelector('[data-sac-projects]');
  var filters = document.querySelectorAll('[data-sac-filter]');
  if (grid && filters.length) {
    filters.forEach(function (btn) {
      btn.addEventListener('click', function () {
        var value = btn.getAttribute('data-sac-filter');
        filters.forEach(function (b) {
          var active = b === btn;
          b.classList.toggle('is-active', active);
          b.setAttribute('aria-pressed', active ? 'true' : 'false');
        });
        grid.querySelectorAll('.sac-project').forEach(function (card) {
          card.hidden = value !== 'all' && card.getAttribute('data-industry') !== value;
        });
      });
    });
  }

  /* Careers: preselect position from "Apply Now" */
  document.querySelectorAll('[data-sac-apply]').forEach(function (link) {
    link.addEventListener('click', function () {
      var select = document.getElementById('position');
      if (select) select.value = link.getAttribute('data-sac-apply');
    });
  });

  /* Forms: client-side file size check + prevent double submit */
  document.querySelectorAll('form[data-sac-form]').forEach(function (form) {
    form.addEventListener('submit', function (e) {
      var file = form.querySelector('input[type="file"][data-max-bytes]');
      if (file && file.files && file.files[0]) {
        var max = parseInt(file.getAttribute('data-max-bytes'), 10);
        if (file.files[0].size > max) {
          e.preventDefault();
          file.setCustomValidity('Please upload a file under 5 MB.');
          file.reportValidity();
          return;
        }
      }
      var submit = form.querySelector('[type="submit"]');
      if (submit) {
        submit.disabled = true;
        submit.setAttribute('aria-busy', 'true');
      }
    });
    var fileInput = form.querySelector('input[type="file"]');
    if (fileInput) fileInput.addEventListener('change', function () { fileInput.setCustomValidity(''); });
  });

  /* Footer year */
  document.querySelectorAll('[data-sac-year]').forEach(function (el) {
    el.textContent = String(new Date().getFullYear());
  });
})();
