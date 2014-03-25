// https://gist.github.com/WebMaestroFr/9481254
(function ($) {
  'use strict';
  $.fn.bsTiles = function () {
    var container = $(this),
      tiles = $('[class^="col-"],[class*=" col-"]', container),
      arrange = function () {
        var places = [{
            t: 0,
            l: 0,
            w: container.innerWidth()
          }],
          p = 0, // Place index
          n, // Next place index
          updateIndexes = function () {
            var i;
            for (i = 0; i < places.length; i += 1) {
              if (i === 0 || places[i].t < places[p].t) { p = i; }
            }
            switch (p) {
            case 0:
              n = p + 1;
              break;
            case places.length - 1:
              n = p - 1;
              break;
            default:
              n = places[p + 1].t < places[p - 1].t ? p + 1 : p - 1;
            }
          },
          fit = function (tile) {
            var w = $(tile).outerWidth(),
              h = $(tile).outerHeight();
            if (w < places[p].w + 2) {
              if (w < places[p].w) {
                places.splice(p + 1, 0, {
                  t: places[p].t,
                  l: places[p].l + w,
                  w: places[p].w - w
                });
                places[p].w = w;
              }
              $(tile).css({
                position: 'absolute',
                top: places[p].t,
                left: places[p].l
              });
              places[p].t += h;
              if (places[p].t > container.height()) {
                container.height(places[p].t);
              }
              updateIndexes();
              return true;
            }
            return false;
          },
          merge = function () {
            places[n].w += places[p].w;
            places[n].l = places[(p < n) ? p : n].l;
            places.splice(p, 1);
            updateIndexes();
          };
        tiles.removeAttr('style');
        if (tiles.css('float') === 'left') {
          $.map(tiles, function (tile) {
            while (!fit(tile)) { merge(); }
          });
        }
      };
    container.css({ position: 'relative' });
    setTimeout(function () { arrange(); }, 400);
    $(window).resize(function () { arrange(); });
  };
}(jQuery));

// https://gist.github.com/WebMaestroFr/9405966
(function ($) {
  'use strict';
  $.fn.bsPeekabooLabel = function () {
    var input = $(this),
      control = input.closest('[class*="col-"]'),
      label = control.siblings('.control-label'),
      show = false,
      toggle = function (d) {
        var m;
        if ($(control).css('float') === 'left') {
          m = '0 0 0 ' + label.outerWidth() + 'px';
          label.animate({ margin: show ? 0 : m, opacity: show ? 1 : 0 }, d);
          control.animate({ margin: m }, d);
        } else {
          label.animate({ margin: 0, opacity: 1 }, d);
          control.animate({ margin: show ? label.outerHeight() + 'px 0 0' : 0 }, d);
        }
        show = !show;
      };
    label.css({ position: 'absolute' });
    toggle(0);
    input.keyup(function () {
      var empty = !input.val();
      if (show !== empty) { toggle(400); }
    });
    $(window).resize(function () { toggle(0); });
  };
  $('.form-control[placeholder]', '.form-horizontal').each(function () {
    $(this).bsPeekabooLabel();
  });
}(jQuery));
