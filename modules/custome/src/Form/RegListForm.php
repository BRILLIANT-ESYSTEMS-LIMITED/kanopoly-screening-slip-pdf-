<?php

namespace Drupal\screeningslip\Form;
use Drupal\file\Entity\File;
require('vendor/setasign/fpdf/fpdf.php');


use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;
use Drupal\Core\Url;

class RegListForm extends FormBase {

  public function getFormId() {
    return 'reglist_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

  
    $keyword = $_SESSION['keyword'];




    $form['container'] = [
      '#type' => 'container',
      '#attributes' => [
        'class' => [
          'accommodation',
        ],
      ]
    ];

    $form['container']['keyword'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Search Word'),
      '#size' => 30,
    ];
    $form['container']['actions']['search'] = ['#type' => 'submit', '#value' => $this->t('Search'),];
    $form['container']['actions']['reset'] = ['#type' => 'submit', '#value' => $this->t('Reset'),];

    $form['pager'] = ['#type' => 'pager'];
    $header = [ 'Photo', 'Id', 'Full Name', 'Application No.', 'Date of Birth', 'Gender', 'Marital Status',  'Lga/State', 'Place of Birth', 'Religion', 'School', 'Department', 'Programme Applied', 'View', 'Edit', 'Delete', 'Slip'];

    $query = \Drupal::database()->select('_students', 'tb');
    $query->fields('tb');
    if ($keyword) {
      $query->condition('tb.firstname', '%'.$keyword.'%', 'LIKE');
    }
    $pager = $query->extend('Drupal\Core\Database\Query\PagerSelectExtender')->limit(10);

    $results = $pager->execute()->fetchAll();

    $rows = array();
    foreach ($results as $r) {
      $view = Link::fromTextAndUrl('View', new Url('screeningslip.regview', ['id' => $r->id], ['attributes' => ['class' => ['button']]]));
      $edit = Link::fromTextAndUrl('Edit', new Url('screeningslip.regform_edit', ['id' => $r->id], ['attributes' => ['class' => ['button']]]));
      $delete = Link::fromTextAndUrl('Delete', new Url('screeningslip.reglist', ['id' => $r->id], ['attributes' => ['class' => ['button']]]));
      $print = Link::fromTextAndUrl('print', new Url('screeningslip.regpdf', ['id' => $r->id], ['attributes' => ['class' => ['button']]]));
      
 // PHOTO START
    if(isset($r->photo)) {

      $file = File::load($r->photo);

    if($file) {
     $file_uri = $file->getFileUri();
     $file_name = $file->getFilename();
     $image_path = file_url_transform_relative(file_create_url($file_uri));
     $photo = ['data' => [
      '#theme' => 'image_style',
      '#style_name' => 'thumbnail',
      '#uri' => $file_uri,
      // optional parameters
      '#width' => 100,
      '#height' => 100,
   ] ];

    // \Drupal::logger('mannirtrs_file')->notice(print_r($image_path, TRUE));
   }
  }

     $form['table'] = [
      '#type' => 'table',
      '#caption' => $this->t('Registration list'),
      '#header' => $header,
      '#rows' => $rows,
    ];
    $form['actions'] = [
      '#type' => 'actions',
    ];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    $form['actions']['export'] = ['#type' => 'submit', '#value' => $this->t('Export'),];


    if ($keyword) {
      // $this->messenger()->addMessage($keyword);
      $form['container']['keyword']['#default_value'] = $keyword;
    }

      $rows[$r->id] = [
      'photo' => $photo,
      'id' => $r->id,
      'fullname' => $r->fullname,
      'applicationno' => $r->applicationno,
      'dateofbirth' => $r->dateofbirth,
      'gender' => $r->gender,
      'maritalstatus' => $r->maritalstatus,
      'lga/state' => $r->lgastate,
      'placeofbirth' => $r->placeofbirth,
      'religion' => $r->religion,
      'school' => $r->school,
      'department' => $r->department,
      'programmeapplied' => $r->programmeapplied,
      'view' => $view,
      'edit' => $edit,
      'delete' => $delete,
      'print' => $print,
      
      ];
    }

    $form['table'] = [
      '#type' => 'table',
      '#caption' => $this->t('Registration list'),
      '#header' => $header,
      '#rows' => $rows,
    ];

    $form['actions'] = [
      '#type' => 'actions',
    ];

    $form['actions//use Nekman\LuhnAlgorithm\LuhnAlgorithmFactory;']['deleteall'] = ['#type' => 'submit', '#value' => $this->t('Delete All'),];


    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    $title = $form_state->getValue('title');
    if (strlen($title) < 5) {
    }
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    //
    $op = $form_state->getValue('op');
    $keyword = $form_state->getValue('keyword');
    $this->messenger()->addMessage($keyword);

    if ($op == 'Search') {
      $_SESSION['keyword'] = $keyword;

    }
    if ($op == 'Reset') {
      unset($_SESSION['keyword']);
    }

    if ($op == 'Delete All') {
      \Drupal::database()->truncate('_students')->execute();
    }



  }

}




