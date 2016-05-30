<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use AppBundle\Entity\user;
use AppBundle\Entity\annoce;

class PdfController extends Controller
{
   /**
     * @Route("/fiche/stat5", name="/fiche/stat5")
    */
      public function statAction(Request $request)
      {
          $sess = $request->getSession();
          $id = $sess->get('id');
        $data =array();
        $salarie = $this->getDoctrine()->getRepository('AppBundle:salarie')->find($id);
        $sh = $this->getDoctrine()->getRepository('AppBundle:salarie')->find($salarie->getSuperieurHierarchique());
        $data[0] = intval($salarie->getSalaire());//Salaire
        $data[1]= $salarie->getNom() ;
        $data[2]= $salarie->getPrenom() ;
        $data[3]= $salarie->getDateNaissance();
        $data[4]= $salarie->getDateEntre();
        $data[5]= $salarie->getTypeContrat();
        $data[6]= $salarie->getDureeContrat();
        $data[7]= $salarie->getSuperieurHierarchique();
        $data[8]= 2.40;//assurance maladie
        $data[9]= 1.49;//assurance chomage
        $data[10]= 3.49;//assurance apprentissage
        $data[11]=12;//charges
        $data[12]=10;//charges
        $data[13]=6;//charges3
        $data[14]=(2.40/100)*$data[0];//charges
        $data[15]=(1.49/100)*$data[0];//charges
        $data[16]=(3.49/100)*$data[0];//charges3
        $data[17]=$data[0]-($data[14]+$data[15]+$data[16]);
        return $this->render('fiche/pdf.html.twig',array(
            'data' => $data,
            'sh'  => $sh ,
          
        ));
      }



}