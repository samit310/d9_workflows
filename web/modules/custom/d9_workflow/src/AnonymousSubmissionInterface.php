<?php

namespace Drupal\d9_workflow;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\EntityOwnerInterface;
use Drupal\Core\Entity\EntityChangedInterface;

/**
 * Provides an interface defining an anonymous submission entity type.
 */
interface AnonymousSubmissionInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

  /**
   * Gets the anonymous submission title.
   *
   * @return string
   *   Title of the anonymous submission.
   */
  public function getTitle();

  /**
   * Sets the anonymous submission title.
   *
   * @param string $title
   *   The anonymous submission title.
   *
   * @return \Drupal\d9_workflow\AnonymousSubmissionInterface
   *   The called anonymous submission entity.
   */
  public function setTitle($title);

  /**
   * Gets the anonymous submission creation timestamp.
   *
   * @return int
   *   Creation timestamp of the anonymous submission.
   */
  public function getCreatedTime();

  /**
   * Sets the anonymous submission creation timestamp.
   *
   * @param int $timestamp
   *   The anonymous submission creation timestamp.
   *
   * @return \Drupal\d9_workflow\AnonymousSubmissionInterface
   *   The called anonymous submission entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the anonymous submission status.
   *
   * @return bool
   *   TRUE if the anonymous submission is enabled, FALSE otherwise.
   */
  public function isEnabled();

  /**
   * Sets the anonymous submission status.
   *
   * @param bool $status
   *   TRUE to enable this anonymous submission, FALSE to disable.
   *
   * @return \Drupal\d9_workflow\AnonymousSubmissionInterface
   *   The called anonymous submission entity.
   */
  public function setStatus($status);

}
