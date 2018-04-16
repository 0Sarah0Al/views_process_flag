(function ($, Drupal) {

    'use strict';

    Drupal.behaviors.viewsRowColor = {
        attach: function (context) {

            var link = $(context).find('.clicked');
             link.each(function (e) {
               if ($(this).hasClass('green')) {
                    $(this).parents("tr").toggleClass("highlight-green");
                }
               else if ($(this).hasClass('red')) {
                    $(this).parents("tr").toggleClass("highlight-red");
                }
              });

        }
    }
})(jQuery, Drupal);
