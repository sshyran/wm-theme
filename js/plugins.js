(function ($) {
  'use strict';
// https://gist.github.com/WebMaestroFr/9481254
  $.fn.wmTiles = function () {
    var container = $(this),
      tiles = container.children(),
      arrange = function () {
        var places = [{
            t: 0,
            l: 0,
            w: container.width()
          }],
          p = 0,
          n,
          updateIndexes = function () {
            var i;
            for (i = 0; i < places.length; i += 1) {
              if (i === 0 || places[i].t < places[p].t) {
                p = i;
              }
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
              h = $(tile).height();
            if (w < places[p].w + 3) {
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
          container.height(0);
          $.map(tiles, function (tile) {
            while (!fit(tile)) { merge(); }
          });
        } else {
          container.height('auto');
        }
      };
    container.css({ position: 'relative' });
    setTimeout(function () { arrange(); }, 400); // Why the heck can't it work properly straight up ?
    $(window).resize(function () { arrange(); });
  };
// https://gist.github.com/WebMaestroFr/9405966
  $.fn.bsPeekabooLabel = function () {
    var input = $(this),
      control = input.closest('[class*="col-"]'),
      label = control.siblings('.control-label'),
      show = false,
      place = function (d) {
        var m;
        if ($(control).css('float') === 'left') {
          m = '0 0 0 ' + label.outerWidth() + 'px';
          label.animate({ margin: show ? 0 : m, opacity: show ? 1 : 0 }, d);
          control.animate({ margin: m }, d);
        } else {
          label.animate({ margin: 0, opacity: 1 }, d);
          control.animate({ margin: show ? label.outerHeight() + 'px 0 0' : 0 }, d);
        }
      };
    label.css({ position: 'absolute' });
    place(0);
    input.keyup(function () {
      if (show === !input.val()) {
        show = !show;
        place(400);
      }
    });
    $(window).resize(function () { place(0); });
  };
}(jQuery));
