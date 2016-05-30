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

class TableurController extends Controller
{
	 /**
     * @Route("/tableur/stat4", name="/tableur/stat4")
     */
    public function stat4Action(Request $request)
      {
        //temporaire
        $data =array();
        $petit = 0 ;
        $data[0]=$petit ;
      
        return $this->render('/tableur/tab.html.twig',array(
            'data' => $data,
          
        ));
      }

}