<?php

namespace Drupal\views_process_flag\Plugin\views\field;

use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\Plugin\views\field\UncacheableFieldHandlerTrait;
use Drupal\views\ResultRow;
use Drupal\Core\Url;
use Drupal\Core\Link;

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
        return [
            '#markup' => $this->buildLink($values),
            '#cache' => ['max-age' => 0],
        ];
    }

    protected function getText($flag) {
        $text = $this->t('Done?');
        if ($flag === "0") {
            $text = $this->t('No');
        }
        elseif ($flag === "1") {
            $text = $this->t('Yes');
        }
        return $text;
    }

    protected function getColor($flag) {
        $color = 'default';
        if ($flag === "0") {
            $color = 'red';
        }
        elseif ($flag === "1") {
            $color = 'green';
        }
        return $color;
    }

    protected function buildLink($values) {
        $entity = $values->_entity;
        $entity_type = $entity->getEntityType()->id();
        $id = $entity->id();
        $loaded_entity = $entity->load($id);
        $flag = $loaded_entity->get('process_flag')->value;
        $url = Url::fromRoute('views_process_flag.link', [
            'entity_type' => $entity_type,
            'id' => $id,
            'row_index' => $this->view->row_index,
        ]);
        $link = Link::fromTextAndUrl($this->getText($flag), $url)->toRenderable();
        $link['#attributes'] = array(
            'class' => array('flag-operation', 'use-ajax', $this->getColor($flag)),
            'id' => "processed-{$this->view->row_index}",
        );
        return render($link);
    }
}
