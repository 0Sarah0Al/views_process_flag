(function ($, Drupal, drupalSettings) {

    'use strict';

    Drupal.behaviors.viewsRowColor = {
        attach: function (context) {

            $('a.clicked').click(function(e){
                var process_flag = drupalSettings.views_process_flag.process_flag;

               if (process_flag === "1") {
                   $(this).parents("tr").addClass("highlight-green");
                   $(this).parents("tr").removeClass("highlight-red");
                   $(this).text('Yes').fadeIn();
                   alert(process_flag);
                }
               else {
                   $(this).parents("tr").addClass("highlight-red");
                   $(this).parents("tr").removeClass("highlight-green");
                   $(this).text('No').fadeIn();
                   alert(process_flag);
                }
            });
        }
    }
})(jQuery, Drupal, drupalSettings);
