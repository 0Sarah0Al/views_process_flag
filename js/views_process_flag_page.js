(function ($, Drupal) {

    'use strict';

    /**
     * Add Process Flag functionality to views table rows
     */
    Drupal.behaviors.viewsRowColor = {
        attach: function (context, settings) {
            // Iterate over all Process Flag operations links
            $('.flag-operation', context).once('viewsRowColor').each(function () {
                // Update parent row colors
                if ($(this).hasClass('green')) {
                    $(this).parents("tr").addClass("highlight-green");
                }
                else if ($(this).hasClass('red')) {
                    $(this).parents("tr").addClass("highlight-red");
                }

                // Create an AJAX link to change Process Flag value
                $(this).click(function(){ toggleRow(this); });
            });
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
            $(row).parents("tr").addClass("highlight-green");
            $(row).parents("tr").removeClass("highlight-red");
            $(row).text('Yes').fadeIn();
        }
        else {
            $(row).parents("tr").addClass("highlight-red");
            $(row).parents("tr").removeClass("highlight-green");
            $(row).text('No').fadeIn();
        }
    }

})(jQuery, Drupal);
