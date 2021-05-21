<?php

namespace Drupal\prevent_node_delete\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
/**
 * Configure prevent_node_delete settings for this site.
 */
class PreventNodeDeleteSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'prevent_node_delete_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'prevent_node_delete.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('prevent_node_delete.settings');
   $node_types = node_type_get_types();
    if (empty($node_types)) {
      return NULL;
    }
   $options = [];
   foreach ($node_types as $node_type => $type) {
    $options[$node_type] = $type->get('name');
    }
    $form['bundle'] = array(
      '#title' => t('Bundle'),
      '#type' => 'checkboxes',
      '#description' => t('Check the content types that you wish to add restriction on deletion'),
      '#options' => $options,
      '#default_value' => $config->get('bundle'),
    );

  
    $form['delete_button'] = array(
      '#title' => t('Show delete button'),
      '#type' => 'checkbox',
      '#description' => t('This option will show delete button in node delete form page, even when the node is associated with entities'),
      '#default_value' => $config->get('delete_button'),
    );

   
    $form['limit'] = array(
      '#title' => t('Number of entities list to show in node delete form'),
      '#type' => 'textfield',
      '#description' => t("Number of entities list to show in node delete form"),
      '#size' => 2,
      '#default_value' => $config->get('limit'),
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('prevent_node_delete.settings')
      ->set('bundle', $form_state->getValue('bundle'))
      ->set('delete_button', $form_state->getValue('delete_button'))
      ->set('limit', $form_state->getValue('limit'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
