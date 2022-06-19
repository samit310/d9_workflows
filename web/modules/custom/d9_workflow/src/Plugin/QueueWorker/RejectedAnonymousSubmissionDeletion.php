<?php

namespace Drupal\d9_workflow\Plugin\QueueWorker;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Queue\QueueWorkerBase;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines 'd9_workflow_rejected_anonymous_submission_deletion' queue worker.
 *
 * @QueueWorker(
 *   id = "d9_workflow_rejected_anonymous_submission_deletion",
 *   title = @Translation("Rejected Anonymous Submission Deletion"),
 *   cron = {"time" = 60}
 * )
 */
class RejectedAnonymousSubmissionDeletion extends QueueWorkerBase implements ContainerFactoryPluginInterface {

  use StringTranslationTrait;

  /**
   * The entity type manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The logger factory.
   *
   * @var \Drupal\Core\Logger\LoggerChannelFactoryInterface
   */
  protected $loggerFactory;

  /**
   * Constructs RejectedAnonymousSubmissionDeletion class instance.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   Entity type manager service.
   * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $logger_factory
   *   The logger channel factory.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    EntityTypeManagerInterface $entity_type_manager,
    LoggerChannelFactoryInterface $logger_factory,
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityTypeManager = $entity_type_manager;
    $this->loggerFactory = $logger_factory->get('d9_workflow_queue');
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager'),
      $container->get('logger.factory'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function processItem($data) {
    if (!empty($data)) {
      try {
        $rejected_entity = $this->entityTypeManager->getStorage('anonymous_submission')->load($data[0]);
        /*
         * Check if entity exists.
         */
        if ($rejected_entity) {
          $rejected_entity->delete();
          $this->loggerFactory->info($this->t('%title Has been deleted.', ['%title' => $rejected_entity->title->value]));
        }
      }
      catch (\Exception $e) {
        $this->loggerFactory->info($e->getLine() . ': ' . $e->getFile() . ' ' . $e->getMessage());
      }
    }

  }

}
