<?php

declare(strict_types=1);

namespace Drupal\debug_bar;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup as TM;

/**
 * Builds and process a form for debug bar configuration.
 */
final class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'debug_bar_settings_form';
  }

  /**
   * {@inheritdoc}
   *
   * @phpstan-ignore-next-line
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {

    $form['position'] = [
      '#type' => 'radios',
      '#title' => new TM('Position'),
      '#options' => [
        'top_left' => new TM('Top left'),
        'top_right' => new TM('Top right'),
        'bottom_left' => new TM('Bottom left'),
        'bottom_right' => new TM('Bottom right'),
      ],
      '#default_value' => $this->config('debug_bar.settings')->get('position'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   *
   * @phpstan-ignore-next-line
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->config('debug_bar.settings')
      ->set('position', $form_state->getValue('position'))
      ->save();
    parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   *
   * @phpstan-return list<string>
   */
  protected function getEditableConfigNames(): array {
    return ['debug_bar.settings'];
  }

}
