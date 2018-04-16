<?php

/**
 * @file
 * Contains views_process_flag\views_process_flag.views.inc..
 * Provide a custom views field data that isn't tied to any other module. */


/**
* Implements hook_views_data().
*/
function views_process_flag_views_data() {

    $data['views']['table']['group'] = t('Custom Global');
    $data['views']['table']['join'] = [
      // #global is a special flag which allows a table to appear all the time.
      '#global' => [],
    ];


    $data['views']['views_process_flag_field'] = [
        'title' => t('Process Flag'),
        'help' => t('flag a row as processed'),
        'field' => [
            'id' => 'views_process_flag_field',
        ],
    ];

    return $data;
}
