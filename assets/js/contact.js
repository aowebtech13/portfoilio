/**
 * Contact form handler.
 * - Reads values from #contact-form
 * - POSTs to api.contact.submit() (Laravel /api/contact)
 * - Renders success/error messages into .messages
 */
(function () {
  'use strict';

  function ready(fn) {
    if (document.readyState !== 'loading') fn();
    else document.addEventListener('DOMContentLoaded', fn);
  }

  // Pre-built escape lookup table (avoid HTML entities that confuse linters).
  var ESCAPES = {
    '&': '&',
    '<': '<',
    '>': '>',
    '"': '"',
    "'": '&#x27;',
    '/': '&#x2F;'
  };

  function escapeHtml(s) {
    if (s === null || s === undefined) return '';
    return String(s).replace(/[&<>"'\/]/g, function (ch) {
      return ESCAPES[ch];
    });
  }

  function renderMessage(box, type, text, errors) {
    var html = '<div class="alert alert-' + type + '">';
    html += escapeHtml(text);
    if (errors && typeof errors === 'object') {
      Object.keys(errors).forEach(function (key) {
        var field = key.charAt(0).toUpperCase() + key.slice(1);
        var list = (errors[key] || []).map(escapeHtml).join(', ');
        html += '<div><strong>' + escapeHtml(field) + ':</strong> ' + list + '</div>';
      });
    }
    html += '</div>';
    box.innerHTML = html;
    box.scrollIntoView({ behavior: 'smooth', block: 'center' });
  }

  ready(function () {
    if (typeof window.api === 'undefined') {
      console.warn('[contact.js] window.api is not available. Did you load api.js?');
      return;
    }

    var form = document.getElementById('contact-form');
    var messageBox = document.querySelector('.messages');

    if (!form) {
      console.warn('[contact.js] #contact-form not found on this page.');
      return;
    }
    if (!messageBox) {
      console.warn('[contact.js] .messages container not found on this page.');
      return;
    }

    form.addEventListener('submit', function (e) {
      e.preventDefault();

      var submitBtn = form.querySelector('button[type="submit"]');
      var originalLabel = submitBtn ? submitBtn.innerHTML : '';
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="text-uppercase fs-14 fw-500">Sending...</span>';
      }

      messageBox.innerHTML = '';

      var fd = new FormData(form);
      var payload = {
        name: fd.get('name') || '',
        email: fd.get('email') || '',
        subject: fd.get('subject') || '',
        message: fd.get('message') || ''
      };

      window.api.contact
        .submit(payload)
        .then(function (data) {
          renderMessage(
            messageBox,
            'success',
            (data && data.message) || 'Your message has been sent successfully!'
          );
          form.reset();
        })
        .catch(function (err) {
          var status = err && err.response && err.response.status;
          var data = err && err.response && err.response.data;
          if (status === 422 && data && data.errors) {
            renderMessage(
              messageBox,
              'danger',
              (data && data.message) || 'Please fix the highlighted errors.',
              data.errors
            );
          } else if (status === 500) {
            renderMessage(
              messageBox,
              'danger',
              (data && data.message) || 'Server error. Please try again later.'
            );
          } else {
            renderMessage(
              messageBox,
              'danger',
              'Network error. Please check your connection and try again.'
            );
          }
        })
        .then(function () {
          if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalLabel;
          }
        });
    });
  });
})();