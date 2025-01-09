<?php

namespace Drupal\recipe\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;

class RecipeForm extends FormBase {

  protected $node;

  public function getFormId() {
    return 'recipe_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state, $nid = NULL) {
    // Nếu có nid, load node để sửa.
    if ($nid) {
      $this->node = Node::load($nid);
    }

    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#required' => TRUE,
      '#default_value' => $this->node ? $this->node->getTitle() : '',
    ];

    $form['body'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Body'),
      '#required' => TRUE,
      '#default_value' => $this->node ? $this->node->get('body')->value : '',
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save'),
    ];

    if ($this->node) {
      $form['actions']['delete'] = [
        '#type' => 'submit',
        '#value' => $this->t('Delete'),
        '#submit' => ['::deleteRecipe'],
      ];
    }

    $form['#attached']['library'][] = 'recipe/bootstrap';

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();

    if ($this->node) {
      // Cập nhật node hiện có.
      $this->node->set('title', $values['title']);
      $this->node->set('body', $values['body']);
      $this->node->save();
      $this->messenger()->addMessage($this->t('Recipe updated.'));
    } else {
      // Tạo node mới.
      $node = Node::create([
        'type' => 'recipe',
        'title' => $values['title'],
        'body' => $values['body'],
      ]);
      $node->save();
      $this->messenger()->addMessage($this->t('Recipe created.'));
    }

    $form_state->setRedirect('recipe_module.list');
  }

  public function deleteRecipe(array &$form, FormStateInterface $form_state) {
    if ($this->node) {
      $this->node->delete();
      $this->messenger()->addMessage($this->t('Recipe deleted.'));
      $form_state->setRedirect('recipe_module.list');
    }
  }
}