<?php

namespace Drupal\views_process_flag\Plugin\views\field;

use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\Plugin\views\field\UncacheableFieldHandlerTrait;
use Drupal\views\ResultRow;

/**
 * A handler to provide a field that is completely custom by the administrator.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("views_process_flag_field")
 */
class ViewsProcessFlag extends FieldPluginBase {

    use UncacheableFieldHandlerTrait;

  /**
   * {@inheritdoc}
   */
  public function query() {
    // Do nothing -- to override the parent query.
  }

    /**
     * {@inheritdoc}
     */
    protected function defineOptions() {
        $options = parent::defineOptions();

        $options['hide_alter_empty'] = ['default' => FALSE];
        return $options;
    }

    /**
     * {@inheritdoc}
     */
    public function buildOptionsForm(&$form, FormStateInterface $form_state) {
        parent::buildOptionsForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function render(ResultRow $values) {

        $row_index = $this->view->row_index;
        $entity = $values->_entity;
        $entity_type = $entity->getEntityType()->id();
        $id = $entity->id();
        $loaded_entity = $entity->load($id);
        $process_flag_value = $loaded_entity->get('process_flag')->value;

        if ($process_flag_value === "1") {
            $link = "<a href=\"nojs/processed/{$entity_type}/{$id}/{$row_index}\" class=\"use-ajax clicked green\" id=\"processed-{$row_index}\">" . $this->t('Yes') . "</a>";
        }
        elseif ($process_flag_value === "0") {
            $link = "<a href=\"nojs/processed/{$entity_type}/{$id}/{$row_index}\" class=\"use-ajax clicked red\" id=\"processed-{$row_index}\">" . $this->t('No') . "</a>";
        }
        else {
            $link = "<a href=\"nojs/processed/{$entity_type}/{$id}/{$row_index}\" class=\"use-ajax clicked\" id=\"processed-{$row_index}\">" . $this->t('Done?') . "</a>";
        }
        return [
            '#markup' => $link,
            '#cache' => ['max-age' => 0],
        ];
    }
}
