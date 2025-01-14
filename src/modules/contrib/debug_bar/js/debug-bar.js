/**
 * @file
 * Debug Bar behaviors.
 */

(function (Drupal, document) {
  'use strict';

  Drupal.behaviors.debugBar = {
    attach (context) {
      const [debugBar] = once('debug_bar', '#debug-bar', context);
      if (!debugBar) {
        return;
      }

      const toggler = debugBar.querySelector('#debug-bar-toggler');
      const togglerContent = toggler.querySelector('span');
      const items = debugBar.querySelector('#debug-bar-items');

      const isHidden = () => (document.cookie.match('(^|;)\\s*debug_bar_hidden\\s*=\\s*([^;]+)')?.pop() || 'true') === 'true';

      const toggle = () => {
        items.hidden = !items.hidden;
        document.cookie = `debug_bar_hidden=${items.hidden}; path=/`;

        if (items.hidden) {
          toggler.setAttribute('aria-expanded', 'false');
          toggler.classList.remove('js-debug-bar__toggler_expanded');
          toggler.title = Drupal.t('Show debug bar');
          togglerContent.innerHTML = toggler.title;
        }
        else {
          toggler.setAttribute('aria-expanded', 'true');
          toggler.classList.add('js-debug-bar__toggler_expanded');
          toggler.title = Drupal.t('Hide debug bar');
          togglerContent.innerHTML = toggler.title;
        }
      };

      if (!isHidden()) {
        toggle();
      }
      toggler.addEventListener('click', toggle);
    }
  };

})(Drupal, document);
