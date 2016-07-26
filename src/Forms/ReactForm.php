<?php

namespace Drupal\react_app\Forms;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;

class ReactForm extends FormBase {
  public function getFormId() {
    return 'React_Login_Form';
  }
  
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['username'] = array(
      '#type' => 'textfield',
      '#title' => t('React-Native Username'),
      '#required' => True,
    );
    $form['email'] = array(
      '#type' => 'email',
      '#title' => t('React-Native Email'),
      '#required' => True,
    );
    $form['password'] = array(
      '#type' => 'password',
      '#title' => t('React-Native Password'),
      '#required' => True,
    );
    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Login'),
    );
    
    return $form;
  }
  
  public function validateForm(array &$form, FormStateInterface $form_state) {
     
  }
  
  public function submitForm(array &$form, FormStateInterface $form_state) {
    foreach ($form_state->getValue() as $key => $value) {
        drupal_set_message($key . ':' . $value);
    }
  }
}
