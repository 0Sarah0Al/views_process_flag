(function ($, Drupal) {

    'use strict';

    /**
     * Add Process Flag functionality to views table rows
     */
    Drupal.behaviors.viewsRowColor = {
        attach: function (context, settings) {
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
        $(row).toggleClass('on off');

        if ($(row).hasClass('on')) {
            $(row).parents('tr').addClass('highlight-on');
            $(row).parents('tr').removeClass('highlight-off');
            $(row).text('Yes').fadeIn();
        }
        else {
            $(row).parents('tr').addClass('highlight-off');
            $(row).parents('tr').removeClass('highlight-on');
            $(row).text('No').fadeIn();
        }
    }

})(jQuery, Drupal);
