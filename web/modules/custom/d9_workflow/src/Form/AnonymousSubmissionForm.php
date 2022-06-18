<?php

namespace Drupal\d9_workflow\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the anonymous submission entity edit forms.
 */
class AnonymousSubmissionForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {

    $entity = $this->getEntity();
    $result = $entity->save();
    $link = $entity->toLink($this->t('View'))->toRenderable();

    $message_arguments = ['%label' => $this->entity->label()];
    $logger_arguments = $message_arguments + ['link' => render($link)];

    if ($result == SAVED_NEW) {
      $this->messenger()->addStatus($this->t('New anonymous submission %label has been created.', $message_arguments));
      $this->logger('d9_workflow')->notice('Created new anonymous submission %label', $logger_arguments);
    }
    else {
      $this->messenger()->addStatus($this->t('The anonymous submission %label has been updated.', $message_arguments));
      $this->logger('d9_workflow')->notice('Updated new anonymous submission %label.', $logger_arguments);
    }

    $form_state->setRedirect('entity.anonymous_submission.canonical', ['anonymous_submission' => $entity->id()]);
  }

}
