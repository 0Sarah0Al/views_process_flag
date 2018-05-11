(function ($, Drupal) {

    'use strict';

    /**
     * Add Process Flag functionality to views table rows
     */
    Drupal.behaviors.viewsRowColor = {
        attach: function (context, settings) {
            // Iterate over all Process Flag operations links
            $('.flag-operation', context).once('viewsRowColor').each(function () {
                // Initial parent row colors
                if ($(this).hasClass('green')) {
                    $(this).parents('tr').addClass('highlight-green');
                }
                else if ($(this).hasClass('red')) {
                    $(this).parents('tr').addClass('highlight-red');
                }
            });

            /**
             * Update the DOM once the flag has been saved
             * 
             * @param {object} ajax 
             * @param {object} response 
             * @param {object} status 
             */
            Drupal.AjaxCommands.prototype.updateFlagLink = function (ajax, response, status) {
                toggleRow($(response.row));
            };
        }
    }

    /**
     * Update table rows / process flag operations links
     * 
     * @param {object} row 
     */
    function toggleRow(row) {
        $(row).toggleClass('green red');

        if ($(row).hasClass('green')) {
            $(row).parents('tr').addClass('highlight-green');
            $(row).parents('tr').removeClass('highlight-red');
            $(row).text(Drupal.t('Yes').fadeIn());
        }
        else {
            $(row).parents('tr').addClass('highlight-red');
            $(row).parents('tr').removeClass('highlight-green');
            $(row).text(Drupal.t('No').fadeIn());
        }
    }

})(jQuery, Drupal);
