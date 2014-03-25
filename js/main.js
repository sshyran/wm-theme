jQuery(document).ready(function ($) {
  'use strict';
  $('.nav a').each(function () {
    var icon = $(this).find('.glyphicon');
    if (icon.length > 0) {
      $(this).html(icon).tooltip({ placement: 'auto' });
    }
  });
  $('.tiles').bsTiles();

  // http://jqueryvalidation.org/validate
  if ( $.validator ) {
    $.validator.setDefaults({
      highlight: function (el) {
        $(el).closest('.form-group').addClass('has-error');
      },
      unhighlight: function (el) {
        $(el).closest('.form-group').removeClass('has-error');
      },
      errorClass: 'help-block'
    });
  }

});
