<?php

namespace Drupal\screeningslip\Form;


use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class RegForm extends FormBase {

  public function getFormId() {
    return 'screeningslip_reg_form';
  }


  public function buildForm(array $form, FormStateInterface $form_state) {

   


    if ($id) {
      $student = \Drupal::database()->query("select * from _students where id = $id")->fetchObject();
    }
    $form['fullname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Full name'),
      '#default_value' => $student->fullname,

    ];
    $form['applicationno'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Application number'),
      '#default_value' => $student->applicationno,

    ];

    $form['dateofbirth'] = [
      '#type' => 'date',
      '#title' => 'Date of Birth',
      '#default_value' => $student->dateofbirth,

    ];
    $form['gender'] = [
      '#type' => 'select',
      '#title' => 'Gender',
      '#default_value' => $student->gender,
      '#options' => ['-Select-' => '', 'Male' => 'Male', 'Female' => 'Female'],
    ];
    $form['maritalstatus'] = [
      '#type' => 'select',
      '#title' => 'Marital status',
      '#default_value' => $student->maritalstatus,
      '#options' => ['-Select-' => '', 'Single' => 'Single', 'Married' => 'Married'],
    ];
    $form['lga/state'] = [
      '#type' => 'textfield',
      '#default_value' => $student->lgastate,
      '#title' => $this->t('lga/state'),
    ];
    $form['placeofbirth'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Place of birth'),
      '#default_value' => $student->placeofbirth,

    ];

    $form['religion'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Level of entry'),
      '#default_value' => $student->religion,

    ];
    $form['school'] = [
      '#type' => 'textfield',
      '#title' => $this->t('school'),
      '#default_value' => $student->school,

    ];
    $form['department'] = [
      '#type' => 'textfield',
      '#title' => $this->t('department'),
      '#default_value' => $student->department,
  
    ];
    $form['programmeapplied'] = [
      '#type' => 'textfield',
      '#title' => $this->t('programmeapplied'),
      '#default_value' => $student->programmeapplied,
    ];

  
    $validators = [
      'file_validate_extensions' => array('jpg', 'png', 'gif'),
      'file_validate_size' => [1000000],
    ];

    $path = 'http://mannir.net/mannir.jpg';

    // $form['f1']['photo1'] = [ '#markup' => "<img src='$path' width='100' height='100' alt='Photo'/>" ];

      $form['photo'] = [
        '#type' => 'managed_file',
        '#name' => 'photo',
        '#title' => t('Passport Photo'),
        '#size' => 20,
        '#description' => t('JPG format only'),
        '#upload_validators' => $validators,
        '#upload_location' => 'public://photos/',
        // '#default_value' => isset($reg->photo) ? [$reg->photo] : '',
        // '#default_value' => array($reg->photo),
        // '#default_value' => array($reg->photo),
        // '#required' => TRUE,
        // '#default_value' => $this->get('photo'),

        // '#upload_location' => 'public://photos/',
        // '#upload_validators'=>  array('file_validate_name' => array()),
      ];
    
    $form['actions'] = [
      '#type' => 'actions',
    ];

    if ($id) {

      $form['id'] = ['#type' => 'hidden', '#value' => $id ];

      $form['actions']['submit'] = [
        '#type' => 'submit',
        '#value' => $this->t('Edit'),
      ];

    }
    else {
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];
  }

  

    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
     $title = $form_state->getValue('title');
    if (strlen($title) < 5) {
     
    }
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {

    $op = $form_state->getValue('op');

    if ($op == 'Submit') {

      $fullname = $form_state->getValue('fullname');
      $applinumber = $form_state->getValue('applicationno');
      $dateofbirth = $form_state->getValue('dateofbirth');
      $gender = $form_state->getValue('gender');
      $maritalstatus = $form_state->getValue('maritalstatus');
      $lgastate = $form_state->getValue('lgastate');
      $placeofbirth = $form_state->getValue('placeofbirth');
      $religion = $form_state->getValue('religion');
      $school = $form_state->getValue('school');
      $department = $form_state->getValue('department');
      $programmeapplied = $form_state->getValue('programmeapplied');
  
      $this->messenger()->addMessage("congratulation $fullname you have successfully filled your information");
  
// SRTART PHOTO
$fid = $form_state->getValue(['photo', 0]);
$fields['photo'] = $fid;

$photo = $fid;

if(isset($fid)) {
  $fields['photo'] = $fid;

  // if (!$form_state->getErrors() && !empty($fid)) {
    $rrr = $uid;
    try {
      $file = File::load($fid);
      $file->setFilename($rrr);
      $file->save();

      // $host = \Drupal::request()->getHost();
      // \Drupal::logger('mannirigr_photo')->notice('<pre>' . print_r($host, TRUE) . '</pre>');

      try {
        $storage = new StorageClient(['projectId' => 'kanoecommerce']);
        $bucket = $storage->bucket('kanoecommerce.appspot.com');
        $image_path = file_url_transform_relative(file_create_url($file->getFileUri()));
        $image_path = ltrim($image_path, '/');
        $file2 = fopen($image_path, 'r');
        $object = $bucket->upload($file2, ['name' => "$rrr.jpg", 'predefinedAcl' => 'publicRead']);

      } catch (\Throwable $e) {
        \Drupal::logger('mannirigr_error')->notice('<pre>' . print_r($e, TRUE) . '</pre>');
      }


      // $file = File::load($fid);
      // exit($fid);
      $new_filename = $rrr.".jpg";
      // exit($new_filename);

      if (isset($new_filename)) {
        $stream_wrapper = \Drupal::service('file_system')->uriScheme($file->getFileUri());
        $new_filename_uri = "{$stream_wrapper}://photos/{$new_filename}";
        file_move($file, $new_filename_uri);
      }

      // exit('Moded');



    }
    catch (\Throwable $e) {
      
    }
  }

  // END PHOTO

      
    $fields = [
      'id' => $id,
      'fullname' => $fullname,
      '$applicationno' => $applicationno,
      '$dateofbirth' => $dateofbirth,
      '$gender' => $gender,
      '$maritalstatus' => $maritalstatus,
      '$lgastate' => $lgastate,
      '$placeofbirth' => $placeofbirth,
      '$religion' => $religion,
      '$school' => $school,
      '$department' => $department,
      '$programmeapplied' => $programmeapplied,
      'photo' => $photo,


    ];

      $query = \Drupal::database()->insert('_students');
      $query->fields($fields);
      $query->execute();

    }




  }

}
