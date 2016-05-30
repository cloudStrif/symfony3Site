<?php

namespace AppBundle\Controller;

use AppBundle\Entity\conges;
use AppBundle\Entity\formation;
use AppBundle\Entity\formationUser;
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
use Symfony\Component\Serializer\Tests\Normalizer\ObjectConstructorArgsWithDefaultValueDummy;
use Symfony\Component\Validator\Constraints\Date;

class FormationController extends Controller
{

    /**
     * @Route("/conges", name="/conges")
     */
    public function compteAction(Request $request)
    {
        $sess = $request->getSession();
        $pseudo = $sess->get('pseudo');
        $id = $sess->get('id');
        $conge = new conges();

        $form = $this->createFormBuilder($conge)
            //->add('userid',TextType::class)
            ->add('debut',DateType::class)
            ->add('fin',DateType::class)
            ->add('connexion',SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $conge->setUserid($id);
            $conge->setDebut($form['debut']->getData());
            $conge->setFin($form['fin']->getData());
            $em = $this->getDoctrine()->getManager();
            $em->persist($conge);
            $em->flush();
        }
        
        return $this->render('conges/conges.html.twig',array('form' => $form->createView() ));
    }
    /**
     * @Route("/formation", name="formation")
     */
    public function formationAction(Request $request)
    {
        $sess = $request->getSession();
        $idUser = $sess->get('id');
        $formationChoisi=$this->getDoctrine()->getRepository('AppBundle:formationUser')->findByIduser($idUser);
        $formationsAll = $this->getDoctrine()->getRepository('AppBundle:formation')->findAll();
        $formationsUserAll = $this->getDoctrine()->getRepository('AppBundle:formationUser')->findAll();
        $approuve=array();

        $formationChoisiName = array();
        foreach ($formationChoisi as $f){
            array_push($formationChoisiName,$this->getDoctrine()->getRepository('AppBundle:formation')->find($f->getIdFormation()));
            /*if($f->getApprouve()==1){
                array_push($approuve,$this->getDoctrine()->getRepository('AppBundle:formation')->findById($f->getIdFormation()));
            }*/
        }
        foreach ($formationChoisi as $f ){
            if ($f->getApprouve()==1){

                array_push($approuve,$f->getIdformation());
            }
        }

        $salarie = $this->getDoctrine()->getRepository('AppBundle:salarie')->findBySuperieurHierarchique($idUser);
        $demandeName=array();
        $demandeId=array();

        foreach ($salarie as  $s){
            foreach ($formationsUserAll as $d){
                if($s->getId()==$d->getIdUser() && $d->getApprouve()==0){
                    $demandeName[$s->getNom()." ".$s->getPrenom()]=$this->getDoctrine()->getRepository('AppBundle:formation')->find($d->getIdFormation());
                    array_push($demandeId,$s->getId());
                    }
            }
        }

        return $this->render('formation/formation.html.twig',array(
            'formations' => $formationsAll,
            'formationChoisi'=>$formationChoisiName,
            'approuve'=>$approuve,
            'demandeName'=>$demandeName,
            'demandeId' => $demandeId
        ));
    }
    /**
     * @Route("/formation/choisis/{id}", name="formation_choisis")
     */
    public function choiceFormationAction($id,Request $request)
    {
        //$formations = $this->getDoctrine()->getRepository('AppBundle:formation')->find($id);
        $sess = $request->getSession();
        $idUser = $sess->get('id');
        $jf = $sess->get('jf');
        $formation = new formationUser();
        $formation->setIdformation($id);
        $formation->setIduser($idUser);
        $formation->setApprouve(0);

        $em = $this->getDoctrine()->getManager();
        $em->persist($formation);
        $em->flush();
        return $this->redirectToRoute('formation');
    }
    /**
     * @Route("/formation/cancel/{id}", name="formation_cancel")
     */
    public function cancelFormationAction($id,Request $request)
    {
        $sess = $request->getSession();
        $idUser = $sess->get('id');
        $em = $this->getDoctrine()->getManager();
        $formation = $em->getRepository('AppBundle:formationUser')->findOneBy(array('idformation' => $id, 'iduser' => $idUser));
        $em->remove($formation);
        $em->flush();

        return $this->redirectToRoute('formation');
    }

    /**
     * @Route("/formation/approve/{sal}/{id}", name="formation_approve")
     */
    public function approveFormationAction($sal,$id,Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $formation = $em->getRepository('AppBundle:formationUser')->findOneBy(array('idformation' => $id, 'iduser' => $sal));
        $formation->setApprouve(1);
        $em->flush();


        return $this->redirectToRoute('formation');
    }
    /**
     * @Route("/formation/deny/{sal}/{id}", name="formation_deny")
     */
    public function denyFormationAction($sal,$id,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $formation = $em->getRepository('AppBundle:formationUser')->findOneBy(array('idformation' => $id, 'iduser' => $sal));
        $em->remove($formation);
        $em->flush();

        return $this->redirectToRoute('formation');
    }


}
