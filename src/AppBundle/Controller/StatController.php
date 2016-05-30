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

class StatController extends Controller
{

   /**
     * @Route("/stats/stat", name="/stats/stat")
    */
      public function statAction(Request $request)
      {

        $data =array();
        return $this->render('stats/stat.html.twig',array(
            'data' => $data,
          
        ));
      }


    /**
     * @Route("/stats/stat2", name="/stats/stat2")
     */
      public function stat2Action(Request $request)
      {

        $data =array();
        $girl = 0 ;
        $boys = 0 ;
        for($i=2003 ;$i<6036 ; $i++){
             $salarie = $this->getDoctrine()->getRepository('AppBundle:salarie')->find($i);
             if($salarie != null){
             if($salarie->getSexe() =="M"){
                $boys++ ;
             }
             if($salarie->getSexe() =="F"){
                $girl++ ;
             }
         }else break ;
        }
        $data[0]=$boys ;
        $data[1]=$girl ;
        return $this->render('stats/stat2.html.twig',array(
            'data' => $data,
          
        ));
      }
    
    /**
     * @Route("/stats/stat3", name="/stats/stat3")
     */
      public function stat3Action(Request $request)
      {

        $data =array();
        $petit = 0 ;
        $moyen = 0 ;
        $grand = 0 ;
        for($i=2003 ;$i<6036 ; $i++){
             $salarie = $this->getDoctrine()->getRepository('AppBundle:salarie')->find($i);
             if($salarie != null){
             if(intval($salarie->getSalaire()) <2000){
                $petit++ ;
             }
             if(intval($salarie->getSalaire()) >2300 && intval($salarie->getSalaire()) <4000){
                $moyen++ ;
             }
             if( intval($salarie->getSalaire()) >4500){
                $grand++ ;
             }
         }else break ;
        }
        $data[0]=$petit ;
        $data[1]=$moyen ;
        $data[2]=$grand ;
        return $this->render('stats/stat3.html.twig',array(
            'data' => $data,
          
        ));
      }
   /**
     * @Route("/stats/statt", name="/stats/statt")
     */
      public function stattAction(Request $request)
      {

        $data =array();
        $petit = 0 ;
        $moyen = 0 ;
        $grand = 0 ;
        $etranger = 0 ;
        for($i=2003 ;$i<6036 ; $i++){
             $salarie = $this->getDoctrine()->getRepository('AppBundle:salarie')->find($i);
             if($salarie != null){
             if($salarie->getTypeContrat() =="CDI"){
                $petit++ ;
             }else
             if($salarie->getTypeContrat() =="CDD"){
                $moyen++ ;
             }else
              if($salarie->getTypeContrat() =="sta"){
                $grand++ ;
             }else{
                $etranger++;
             }
         }else break ;
        }
        $data[0]=$petit ;
        $data[1]=$moyen ;
        $data[2]=$grand ;
        $data[3]=$etranger ;
        return $this->render('stats/stat4.html.twig',array(
            'data' => $data,
          
        ));
      }

  
}
