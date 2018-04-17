<?php
namespace Drupal\views_process_flag\Ajax;
use Drupal\Core\Ajax\CommandInterface;

/**
 * Provides an AJAX response to a flag status update
 */
class UpdateLinkCommand implements CommandInterface
{
    protected $row;

    public function __construct($row) {
        $this->row = $row;
    }
    
    public function render(){
        return array(
            'command' => 'updateFlagLink',
            'row' => $this->row,
        );
    }
}
