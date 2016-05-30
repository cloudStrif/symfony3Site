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
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @Route("/log/login", name="log/login")
    */
    public function connexionAction(Request $request)
    {
        //$userlist = $this->getDoctrine()->getRepository('AppBundle:user')->findAll();
        $user = new user();
        $form = $this->createFormBuilder($user)
        ->add('pseudo',TextType::class)
        ->add('mdp',PasswordType::class)
        ->add('connexion',SubmitType::class)
        ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $pseudo = $form['pseudo']->getData();
            $userlist = $this->getDoctrine()->getRepository('AppBundle:user')->findOneByPseudo($pseudo);
            if (!$userlist) { 
                return $this->render('log/log.html.twig', array('form' => $form->createView(),"pseudo"=>False) );
            }
            $sess = $request->getSession();
            $sess->set('pseudo', $userlist->getPseudo());
            $sess->set('id',$userlist->getId());
            $sess->set('jf',$userlist->getJourFormation());
            return $this->render('default/index.html.twig');
        }
        return  $this->render('log/log.html.twig',array('form' => $form->createView()));
    }
    /**
     * @Route("/log/test/", name="/log/test")
     */
    public function pseudoCompleteAction($mot,Request $request)
    {
        var_dump($mot);
        if($request->isXmlHttpRequest())
        {

            $array= $this->getDoctrine()
                ->getEntityManager()
                ->getRepository('AppBundle:user')
                ->findAll();
            $final= array();
            foreach ($array as $a){
                    array_push($final, $a->getPseudo());
            }

            $response = new Response(json_encode($final));
            $response -> headers -> set('Content-Type', 'application/json');
            return $response;
        }
        else{
            return $this->redirectToRoute('homepage');
        }

    }
    /**
     * @Route("/log/logout", name="/log/logout")
     */
    public function deconnexionAction(Request $request)
    {
        $sess = $request->getSession('pseudo');
        $sess->invalidate();
        return $this->redirectToRoute('homepage');
    }
    /**
     * @Route("/log/compte", name="/log/compte")
     */
    public function compteAction(Request $request)
    {
        return $this->render('log/compte.html.twig');
    }
    /**
    * @Route("/log/sal", name="/log/sal")
    */
    public function salarieAction(Request $request)
    {
        $salarie = $this->getDoctrine()->getRepository('AppBundle:salarie')->findAll();
        
        foreach ($salarie as $s) {
            set_time_limit(1) ;
            $id = $s->getId();
            $nom = $s->getNom();
            $prenom = $s->getPrenom();
            $user = new user();
            $user->setId($id);
            $user->setPseudo($nom."_".$id);
            $user->setMdp($nom."_".$prenom);
            $user->setJourFormation(90);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }

        return $this->render('default/index.html.twig');
    }
    
}
