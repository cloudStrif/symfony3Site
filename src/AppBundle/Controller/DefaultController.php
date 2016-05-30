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
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use AppBundle\Entity\user;
use AppBundle\Entity\annoce;

class DefaultController extends Controller
{


  /**
   * @Route("/apropos", name="/apropos")
   */
   public function aproposAction(Request $request)
   {
     return $this->render('default/index2.html.twig');
   }

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $annonce = $this->getDoctrine()->getRepository('AppBundle:annonce')->find(1);
        $annonces = $this->getDoctrine()->getRepository('AppBundle:annonce')->findAll();
        $user = new user();
        $form = $this->createFormBuilder($user)
        ->add('pseudo',TextType::class)
        ->add('mdp',PasswordType::class)
        ->add('connexion',SubmitType::class)
        ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $pseudo = $form['pseudo']->getData();
            $mdp = $form['pseudo']->getData();
            $userlist = $this->getDoctrine()->getRepository('AppBundle:user')->findOneByPseudo($pseudo);
            if (!$userlist) {
                return $this->redirectToRoute('homepage');
            }
            if($userlist->getMdp() == $mdp){
                return $this->redirectToRoute('homepage');
            }
            $sess = $request->getSession();
            $sess->set('pseudo', $userlist->getPseudo());
            $sess->set('id',$userlist->getId());
            $sess->set('jf',$userlist->getJourFormation());
            if ($userlist->getModerateur()===true){
                $sess->set('moderateur',$userlist->getModerateur());
            }
            return $this->render('default/index.html.twig',array(
                'annonce' => $annonce,
                'annonces' => $annonces
            ));
        }
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig',array(
            'form' => $form->createView(),
            'annonce' => $annonce,
            'annonces' => $annonces,
            ['base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),

        ]));
    }
    /**
     * @Route("/index2", name="homepage2")
     */
    public function index2Action(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index2.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }
    /**
     * @Route("/affiche", name="affiche")
     */
    public function afficheAction(Request $request)
    {
        $sal = $this->getDoctrine()->getRepository('AppBundle:salarie')->findAll();

        return $this->render('default/index.html.twig',array(
        'sal' => $sal
        ));
    }
    /**
     * @Route("/test", name="test")
     */
    public function testAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('test.html.twig');
    }

    /**
     * @Route("/search", name="search")
     */
    public function searchAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('search',TextType::class)
            ->add('chercher',SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form['search']->getData();
            $formationTrouve=array();
            $formation = $this->getDoctrine()->getRepository("AppBundle:formation")->findAll();
            $salarie= $this->getDoctrine()->getRepository("AppBundle:salarie")->findAll();
            $salarieTrouve=array();
            $themes=$this->getDoctrine()->getRepository("AppBundle:theme")->findAll();
            $themesTrouve=array();
            $sujets=$this->getDoctrine()->getRepository("AppBundle:sujet")->findAll();
            $sujetsTrouve=array();
            foreach ($formation as $f){
                if(strpos($f->getContenu(), $search)){
                    array_push($formationTrouve,$f);
                }
            }

            foreach ($salarie as $s){
                if(strpos(strtolower($s->getNom()), $search) !== false || strpos(strtolower($s->getPrenom()), $search) !== false){
                    array_push($salarieTrouve,$s);
                }
            }

            foreach ($themes as $t){

                if(strpos($t->getNom(),$search) !== false){
                    array_push($themesTrouve,$t);
                }

            }

            foreach ($sujets as $s){
                if(strpos($s->getNom(),$search) !== false){
                    array_push($sujetsTrouve,$s);
                }
            }

            return $this->render('search/search.html.twig',array(
                'form'=>$form->createView(),
                'search'=>$search,
                'formations'=>$formationTrouve,
                'salaries' => $salarieTrouve,
                'themes' => $themesTrouve,
                'sujets' => $sujetsTrouve
            ));

        }


        return $this->render('search/search.html.twig',array(
            'form'=>$form->createView()
        ));
    }


}
