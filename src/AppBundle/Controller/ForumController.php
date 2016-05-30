<?php

namespace AppBundle\Controller;

use AppBundle\Entity\message;
use AppBundle\Entity\sujet;
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
use AppBundle\Entity\theme;


class ForumController extends Controller
{



    /**
     * @Route("/forum/themes", name="/forum/themes")
    */
    public function themeAction(Request $request)
    {
        
        $themes = $this->getDoctrine()->getRepository('AppBundle:theme')->findAll();
        
        return $this->render('forum/forum.html.twig',array(
            'themes' => $themes,
        ));
    }
    /**
     * @Route("/forum/{themeid}/sujet", name="/forum/themes/sujet")
    */
    public function sujetAction($themeid,Request $request)
    {
        $sess = $request->getSession();
        $pseudo = $sess->get('pseudo');
        $now = new\DateTime('now');
        $sujets = $this->getDoctrine()->getRepository('AppBundle:sujet')->findByIdtheme($themeid);
        $theme = $this->getDoctrine()->getRepository('AppBundle:theme')->findOneById($themeid);
        $suj = new sujet();
        $form = $this->createFormBuilder($suj)
            ->add('nom',TextType::class)
            //->add('user',SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $nom=$form['nom']->getData();
            $suj->setNom($nom);
            $suj->setIdtheme($themeid);
            $suj->setUser($pseudo);
            $suj->setDateCreation($now);

            $em = $this->getDoctrine()->getManager();
            $em->persist($suj);
            $em->flush();

            $sujets = $this->getDoctrine()->getRepository('AppBundle:sujet')->findByIdtheme($themeid);
            return $this->render('forum/forum.html.twig',array(
                'sujets' => $sujets,
                'theme' =>$theme,
                'form' => $form->createView(),
                'pseudo' => $pseudo,
                'now' => $now,
            ));
        }
        return $this->render('forum/forum.html.twig',array(
            'sujets' => $sujets,
            'theme' =>$theme,
            'form' => $form->createView(),
            'pseudo' => $pseudo,
            'now' => $now,
        ));
    }
    /**
     * @Route("/forum/theme/{sujetid}/message", name="forum_message")
     */
    public function messageAction($sujetid, Request $request)
    {
        $sess = $request->getSession();
        $pseudo = $sess->get('pseudo');

        $now = new\DateTime('now');
        $messages = $this->getDoctrine()->getRepository('AppBundle:message')->findByIdsujet($sujetid);
        $sujet = $this->getDoctrine()->getRepository('AppBundle:sujet')->find($sujetid);
        $mess = new message();
        $form = $this->createFormBuilder($mess)
            ->add('contenu',TextType::class)
            //->add('user',SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $contenu=$form['contenu']->getData();
            $mess->setContenu($contenu);
            $mess->setIdsujet($sujetid);
            $mess->setUser($pseudo);
            $mess->setDateCreation($now);

            $em = $this->getDoctrine()->getManager();
            $em->persist($mess);
            $em->flush();
            $messages = $this->getDoctrine()->getRepository('AppBundle:message')->findByIdsujet($sujetid);
            return $this->render('forum/forum.html.twig',array(
                'messages' => $messages,
                'form' => $form->createView(),
                'pseudo' => $pseudo,
                'sujet' => $sujet,
                'now' => $now,
            ));
        }
        return $this->render('forum/forum.html.twig',array(
            'messages' => $messages,
            'form' => $form->createView(),
            'pseudo' => $pseudo,
            'sujet' => $sujet,
            'now' => $now,
        ));


    }

    /**
     * @Route(" /forum/{sujetid}/{id}", name="/forum/sujet/{id}")
     */
    public function deleteMessageAction($sujetid,$id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $message = $em->getRepository('AppBundle:message')->findOneById($id);
        $em->remove($message);
        $em->flush();

        $sess = $request->getSession();
        $pseudo = $sess->get('pseudo');

        $now = new\DateTime('now');
        $messages = $this->getDoctrine()->getRepository('AppBundle:message')->findByIdsujet($sujetid);
        $sujet = $this->getDoctrine()->getRepository('AppBundle:sujet')->find($sujetid);
        $mess = new message();
        $form = $this->createFormBuilder($mess)
            ->add('contenu',TextType::class)
            //->add('user',SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $contenu=$form['contenu']->getData();
            $mess->setContenu($contenu);
            $mess->setIdsujet($sujetid);
            $mess->setUser($pseudo);
            $mess->setDateCreation($now);

            $em = $this->getDoctrine()->getManager();
            $em->persist($mess);
            $em->flush();
            $messages = $this->getDoctrine()->getRepository('AppBundle:message')->findByIdsujet($sujetid);
            return $this->render('forum/forum.html.twig',array(
                'messages' => $messages,
                'form' => $form->createView(),
                'pseudo' => $pseudo,
                'sujet' => $sujet,
                'now' => $now,
            ));
        }
        return $this->render('forum/forum.html.twig',array(
            'messages' => $messages,
            'form' => $form->createView(),
            'pseudo' => $pseudo,
            'sujet' => $sujet,
            'now' => $now,
        ));

    }



}
