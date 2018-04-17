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

    protected $text;
    protected $color;
    protected $link;
    protected $entity_type;
    protected $id;
    protected $process_flag;

    /**
     * Constructs a new ViewsProcessFlag instance.
     */
    public function __construct() {
        $this->text = $this->t('Done?');
        $this->color = 'default';
    }

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
        $this->processValues($values);
        $this->setLinkValues();
        $this->buildLink();
        
        return [
            '#markup' => render($this->link),
            '#cache' => ['max-age' => 0],
        ];
    }

    protected function processValues($values) {
        $this->row_index = $this->view->row_index;
        $entity = $values->_entity;
        $this->entity_type = $entity->getEntityType()->id();
        $this->id = $entity->id();
        $loaded_entity = $entity->load($this->id);
        $this->process_flag = $loaded_entity->get('process_flag')->value;
    }

    protected function setLinkValues() {
        if ($this->process_flag === "0") {
            $this->text = $this->t('No');
            $this->color = 'red';
        }
        elseif ($this->process_flag === "1") {
            $this->text = $this->t('Yes');
            $this->color = 'green';
        }
    }

    protected function buildLink() {
        $url = Url::fromRoute('views_process_flag.link', [
            'entity_type' => $this->entity_type,
            'id' => $this->id,
            'row_index' => $this->row_index,
        ]);
        $this->link = Link::fromTextAndUrl($this->text, $url)->toRenderable();
        $this->link['#attributes'] = array(
            'class' => array('flag-operation', 'use-ajax', $this->color),
            'id' => "processed-{$this->row_index}",
        );
    }
}
