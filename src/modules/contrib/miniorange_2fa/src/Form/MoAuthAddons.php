<?php

namespace Drupal\miniorange_2fa\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\miniorange_2fa\MoAuthUtilities;

class MoAuthAddons extends FormBase {

  public function getFormId() {
    return 'mo_2fa_addon_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state, $options = NULL) {
    if(MoAuthUtilities::hideAddonTab()){
      return $form;
    }
      $form['#attached']['library'][] = 'core/drupal.dialog.ajax';
    $form['#attached']['library'][] = 'miniorange_2fa/miniorange_2fa.admin';

    $form['markup_start'] = [
      '#markup' => '<div class="mo_2fa_table_layout_1"><div class="mo_2fa_table_layout mo_container_second_factor">',
    ];

    $form['mo_2fa_addon_heading'] = [
      '#markup' => $this->t('<h4>Addon Management</h4>')
    ];

    $form['mo_2fa_addon_note'] = [
      '#markup' => '<br><div class="mo_2fa_highlight_background_note"><strong>' . t('Note:') . ' </strong>' . t('Uninstall the addon module to disable it.') . '</div><br>',
    ];

    $form['mo_2fa_addon'] = [
      '#type' => 'container',
    ];

    $form['markup_end'] = [
      '#markup' => '</div></div>',
    ];

    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {}

  public function submitForm(array &$form, FormStateInterface $form_state) {}

}
