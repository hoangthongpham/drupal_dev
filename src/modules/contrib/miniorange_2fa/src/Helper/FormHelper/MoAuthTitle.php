<?php

namespace Drupal\miniorange_2fa\Helper\FormHelper;

use Drupal\Core\Form\FormStateInterface;
use Drupal\miniorange_2fa\MoAuthUtilities;
use Drupal\miniorange_2fa\Helper\MoUserUtility;

/**
 * @file
 *  This is used to configure 2fa of the admin
 */
class MoAuthTitle {

  /**
   * Form constructor.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   * @param array $title
   *    The heading name and description of the form.
   *
   * @return array
   *   The form structure.
   */
  public static function buildTitleForm(array &$form, FormStateInterface $form_state, array $title=[] ) {

    if(!empty($title)){
      $form['markup_top_div'] = array(
        '#markup' => '<div><div class="mo_2fa_table_layout mo_container_second_factor">'
      );

      $form['mo_2fa_page_title'] = array(
        '#markup' => '<div class = "mo_2fa_module_header"><div><h2>' . (array_key_exists('name', $title)? $title['name'] : '') . '</h2><div>' . (array_key_exists('description', $title)? $title['description'] : '') . '</div></div>',
      );

      if (MoAuthUtilities::isCustomerRegistered()) {
        $mo_2fa_transactions = array(
          "SMS" => array(
            'type' => "sms",
            'transactions' => MoAuthUtilities::miniorange2FAGetRemainingTransactions( 'sms' ) . ' |',
          ),
          "Email" => array(
            'type' => "email",
            'transactions' => MoAuthUtilities::miniorange2FAGetRemainingTransactions( 'email' ) . ' |',
          ),
          "IVR" => array(
            'type' => "ivr",
            'transactions' => MoAuthUtilities::miniorange2FAGetRemainingTransactions( 'ivr' ),
          ),
        );

        $transactions_div = '';
        foreach ($mo_2fa_transactions as $transaction_name => $transaction_details){
          $transactions_div .='<div class="mo-2fa-remaining-transactions remaining-transactions-' . $transaction_details['type'] . '">' . $transaction_name . ' : ' .  $transaction_details['transactions'] . '</div>';
        }

        $form['mo_2fa_transactions'] = array(
          '#markup' => '<div style="display:flex"><div class="mo-2fa-auth-transactions card" >' . $transactions_div . '',
        );
        $form['mo_2fa_get_transactions'] = array(
          "#type" => 'submit',
          "#value" => t('&#8635;'),
          '#attributes' => [
            'class' => ['button button--small'],
            'title' => t('Fetch Details'),
          ],
          '#submit' => [[new MoUserUtility(), 'moAuthFetchCustomerLicense']],
        );
      }
      $form['markup_top_div_end'] = array(
        '#markup' => '</div></div></div><hr>',
      );
    }
    return $form;
  }

}
