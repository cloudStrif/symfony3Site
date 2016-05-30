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

class AccountController extends Controller
{
    /**
     * @Route("/account/view", name="/account/view")
    */
    public function viewAction(Request $request)
    {
        $sess = $request->getSession();
        $id = $sess->get('id');
        if(!$id){
            return $this->redirectToRoute('log/login');   
        }
        else{
        $salarie = $this->getDoctrine()->getRepository('AppBundle:salarie')->find($id);
        $sh = $this->getDoctrine()->getRepository('AppBundle:salarie')->find($salarie->getSuperieurHierarchique());
        
        return $this->render('account/viewAccount.html.twig',array(
            'salarie' => $salarie,
            'sh' => $sh,
        ));
        }
    }
    /**
     * @Route("/account/edit", name="/account/edit")
    */
    public function editAction(Request $request)
    {
        $sess = $request->getSession();
        $id = $sess->get('id');
        if(!$id){
            return $this->redirectToRoute('log/login');   
        }
        else{
        $salarie = $this->getDoctrine()->getRepository('AppBundle:salarie')->find($id);
        $sh = $this->getDoctrine()->getRepository('AppBundle:salarie')->find($salarie->getSuperieurHierarchique());
        
        return $this->render('account/editAccount.html.twig',array(
            'salarie' => $salarie,
            'sh' => $sh,
        ));
        }
    }

}
