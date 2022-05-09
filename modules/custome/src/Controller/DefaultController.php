<?php

namespace Drupal\screeningslip\Controller;
require('vendor/setasign/fpdf/fpdf.php');
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DefaultController extends ControllerBase {

  protected $repository;



  public function regview($id = null) {

    $request = \Drupal::request();
    if ($route = $request->attributes->get(\Symfony\Cmf\Component\Routing\RouteObjectInterface::ROUTE_OBJECT)) {
      $route->setDefault('_title', '<none>');
    }

    $reg = \Drupal::database()->query("select * from _students where id=$id")->fetchObject();
    
    return [
      '#theme' => 'registration',
      '#reg' => $reg,
    ];
  }

  public function regpdf($id = null)
  {
    $reg = \Drupal::database()->query("select * from _students where id=$id")->fetchObject();
    $pdf = new \FPDF('P','mm','A4');
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',14);
    // $pdf->setXY(50, 100);

    $pdf->Image('/opt/lampp/htdocs/screeningslip/modules/custome/logo.jpeg', 25, 10, 20, 20);
    $pdf->SetFont('Arial','B',20);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(0,8,'KANO STATE POLYTECHNIC', 0, 0, 'C');
    $pdf->SetFont('Arial','B',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Ln(7);
    $pdf->Cell(0,5,'BUK Road, PMB 3401, KANO - NIGERIA', 0, 0, 'C');
    $pdf->Ln(7);
    $pdf->Cell(0,5,'(Office of the Registrar)', 0, 0, 'C');
    $pdf->Ln(10);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(0,5,'ND/NCE SCREENING SLIP (2020/2021) SESSION', 0, 0, 'C');
    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(0,5,'_______________________________________________________________________________________________________________________', 0, 0, 'C');
    $pdf->Ln();
    $pdf->Cell(0,5,'_______________________________________________________________________________________________________________________', 0, 0, 'C');
    $w = 70;
    $w2 = 70;//require('/opt/lampp/htdocs/screeningslip/vendor/fzaninotto/faker/src/autoload.php');
    $h = 7;
    $h2 = 7;
    $pdf->Ln();
    $pdf->Cell($w,$h,'FULL NAME:', 0, 0);
    $pdf->Cell($w2,$h2,$students->fullname, 0, 0);
    $pdf->Ln();
    $pdf->Cell($w,$h,'APPLICATION NO.:', 0, 0);
    $pdf->Cell($w2,$h2,$students->applicationno, 0, 0);
    $pdf->Ln();
    $pdf->Cell($w,$h,'DATE OF BIRTH:', 0, 0);
    $pdf->Cell($w2,$h2,$students->dateofbirth, 0, 0);
    $pdf->Ln();
    $pdf->Cell($w,$h,'GENDER:', 0, 0);
    $pdf->Cell($w2,$h2,$students->gender, 0, 0);
    $pdf->Ln();
    $pdf->Cell($w,$h,'MARITAL STATUS:', 0, 0);
    $pdf->Cell($w2,$h2,$students->maritalstatus, 0, 0);
    $pdf->Ln();
    $pdf->Cell($w,$h,'LGA/STATE:', 0, 0);
    $pdf->Cell($w2,$h2,$students->lgastate, 0, 0);
    $pdf->Ln();
    $pdf->Cell($w,$h,'PLACE OF BIRTH:', 0, 0);
    $pdf->Cell($w2,$h2,$students->placeofbirth, 0, 0);
    $pdf->Ln();
    $pdf->Cell($w,$h,'RELIGION:', 0, 0);
    $pdf->Cell($w2,$h2,$students->religion, 0, 0);
    $pdf->Ln();
    $pdf->Cell($w,$h,'SCHOOL:', 0, 0);
    $pdf->Cell($w2,$h2,$students->school, 0, 0);
    $pdf->Ln();
    $pdf->Cell($w,$h,'DEPARTMENT:', 0, 0);
    $pdf->Cell($w2,$h2,$students->department, 0, 0);
    $pdf->Ln();
    $pdf->Cell($w,$h,'PROGRAMME APPLIED:', 0, 0);
    $pdf->Cell($w2,$h2,$students->programmeapplied, 0, 0);
    $pdf->Ln();
    $pdf->Cell(195,5,'CONTACT INFORMATION', 1, 0, 'C');
    $pdf->Ln();
    $pdf->Cell(97.5,$h,'Email: Phone No.: ', 1, 0);
    $pdf->Cell(97.5,$h,'Contact Add: Permanent Add:', 1, 0);
    $pdf->Ln(10);
    $pdf->Cell(195,5,'SCHOOLS ATTENDED WITH DATE', 1, 0, 'C');
    $pdf->Ln();
    $pdf->Cell(67,$h,'Primary School Attended', 1, 0);
    $pdf->Cell(68,$h,'', 1, 0);
    $pdf->Cell(60,$h,'', 1, 0);
    $pdf->Ln();
    $pdf->Cell(67,$h,'Secondary School Attended', 1, 0);
    $pdf->Cell(68,$h,'', 1, 0);
    $pdf->Cell(60,$h,'', 1, 0);
    $pdf->Ln();
    $pdf->Cell(195,5,'HIGHEST QUALIFICATION: (O-LEVEL (SSCE))', 1, 0, 'C');
    $pdf->Ln(10);
    $pdf->Cell(195,5,'RESULTS', 1, 0, 'C');
    $pdf->Ln();
    $pdf->Cell(50,$h,'SSCE Result(s)', 1, 0);
    $pdf->Cell(145,$h,'', 1, 0);
    $pdf->Ln();
    $pdf->Cell(50,$h,'UTME Result', 1, 0);
    $pdf->Cell(145,$h,'', 1, 0);
    $pdf->Ln(10);
    $pdf->Cell(195,5,'NEXT OF KIN', 1, 0, 'C');
    $pdf->Ln();
    $pdf->Cell(67,$h,'Name:', 1, 0);
    $pdf->Cell(68,$h,'Relationship:', 1, 0);
    $pdf->Cell(60,$h,'Phone No.:', 1, 0);
    $pdf->Ln(10);
    $pdf->Cell(195,5,'SPONSORSHIP', 1, 0, 'C');
    $pdf->Ln();
    $pdf->Cell(70,$h,'Sponsor Type:', 1, 0);
    $pdf->Cell(125,$h,'Sponsor Name:', 1, 0);
    $pdf->Ln(12);
    $pdf->Cell($w,$h,'NOTE: This also serve as a formal invitation for the screening exercise which is scheduled as follows:', 0, 0);
    $pdf->Ln();
    $pdf->Cell($w,$h,'       DATE:', 0, 0);
    $pdf->Ln();
    $pdf->Cell($w,$h,'       TIME:', 0, 0);
    $pdf->Ln();
    $pdf->Cell($w,$h,'       VENUE:', 0, 0);
    $pdf->Ln(10);
    $pdf->Cell($w,$h,'You are also required to abide by the following:', 0, 0);
    $pdf->Ln();
    $pdf->Cell($w,$h,'   1. You must appear physically with original copies of your credentials:', 0, 1);
    $pdf->Cell($w,$h,'   2. You must come along with a copy of this slip:', 0, 1);
    $pdf->Cell($w,$h,'   3. You must have chosen Kano State Polytechnic as your first choice and print out  :', 0, 1);
    $pdf->Cell($w,$h,'   4. You must have upload your o-level results on the JAMB Websites and print out:', 0, 1);
    $pdf->Cell($w,$h,'   5. You are expected to have started checking JAMB & Polytechnic portal for admission status from .......:', 0, 1);
    
    // PHOT START
    if(isset($students->photo)) {
      $file = File::load($students->photo);
      if($file) {
        $file_uri = $file->getFileUri();
        $file_name = $file->getFilename();
        $image_path = file_url_transform_relative(file_create_url($file_uri));
        $pdf->Image($file_uri,5,10, 0, 0);
      }
    }

    $text = $journalName = preg_replace('/\s+/', '_', $students->name);


    // PHOTO END

    
    $pdf->Output();
    exit();

    return ['#markup' => 'PDF'];
  }

 
  
}