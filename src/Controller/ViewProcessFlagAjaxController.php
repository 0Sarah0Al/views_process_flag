<?php

namespace Drupal\views_process_flag\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
/**
 * Provides route responses for the views process flag link.
 */
class ViewProcessFlagAjaxController extends ControllerBase {

    /**
     * @var \Drupal\Core\Entity\EntityTypeManagerInterface
     */
    protected $entityTypeManager;

    /**
     * The currently active route match object.
     *
     * @var \Drupal\Core\Routing\RouteMatchInterface
     */
    protected $routeMatch;

    /**
     * Creates a new ViewProcessFlagAjaxController instance.
     *
     * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
     *   The entity manager.
     * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
     *   The currently active route match object.
     */
    public function __construct(EntityTypeManagerInterface $entity_type_manager, RouteMatchInterface $route_match) {
        $this->entityTypeManager = $entity_type_manager;
        $this->routeMatch = $route_match;
    }

    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container){
        return new static(
            $container->get('entity_type.manager'),
            $container->get('current_route_match')
        );
    }
    /**
     * Returns a ajax callback.
     *
     * @return array
     *   A simple response.
     */
    public function processFlagLinkAjax() {

        $result[] ='';
        $entity_type = $this->routeMatch->getParameter('entity_type');
        $entity_id = $this->routeMatch->getParameter('id');
        $row_index = $this->routeMatch->getParameter('row_index');
        $entity = $this->entityTypeManager->getStorage($entity_type)->load($entity_id);
        $process_flag_value = $entity->get('process_flag')->value;

        if ($process_flag_value === "1") {
          $entity->set('process_flag', "0");
          $entity->save();
          $process_flag = $entity->get('process_flag')->value;
        }
        elseif ($process_flag_value === "0") {
          $entity->set('process_flag', "1");
          $entity->save();
          $process_flag = $entity->get('process_flag')->value;
        }
        else {
            $entity->set('process_flag', "1");
            $entity->save();
            $process_flag = $entity->get('process_flag')->value;
        }

        $result['#attached']['library'][]='views_process_flag/views_process_flag.general';
        $result['#attached']['drupalSettings']['views_process_flag']['process_flag'] = $process_flag;
        $result['#attached']['drupalSettings']['views_process_flag']['row_index'] = $row_index;
        $result['#cache']['max-age'] = 0;

        return $result;
    }
}
