<?php

namespace AppBundle\Controller;

use AppBundle\Entity\chat;
use AppBundle\Entity\chatMessage;
use AppBundle\Entity\chatUser;
use AppBundle\Entity\message;
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

class ChatController extends Controller
{
	/**
     * @Route("/chat/chat1", name="chat/chat1")
    */
     public function chatAction(Request $request)
	{
	   $data =array();
	    $sess = $request->getSession();
	   $id = $sess->get('id');
	   $salarie = $this->getDoctrine()->getRepository('AppBundle:salarie')->find($id);
	    $data[0]= $salarie->getNom() ;
        $data[1]= $salarie->getPrenom() ;
	   
        return $this->render('chat/chat.html.twig',array(
            'data' => $data,
          
        ));
    }
    /**
     * @Route("/chat", name="/chat")
     */
    public function convertationAction(Request $request)
    {
        $sess = $request->getSession();
        $id = $sess->get('id');
        $pseudo = $this->getDoctrine()->getRepository("AppBundle:salarie")->find($id);
        $allchats = $this->getDoctrine()->getRepository('AppBundle:chat')->findAll();
        $allChatUser = $this->getDoctrine()->getRepository('AppBundle:chatUser')->findByIduser($id);
        $chats = array();
        dump($allchats);
        foreach ($allChatUser as $cu){
            foreach ($allchats as $c){
                if($cu->getIdchat() == $c->getId()){
                    array_push($chats,$c);
                }
            }
        }

        $chatUser = new chatUser();
        $chat = new chat();
        $now = new\DateTime('now');
        $form = $this->createFormBuilder($chat)
            ->add('nom',TextType::class)
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $nom = $form['nom']->getData();
            $chat->setNom($nom);
            $chat->setIduser($id);
            $chat->setDate($now);
            $em = $this->getDoctrine()->getManager();
            $em->persist($chat);
            $em->flush();
            $chatUser->setIdchat($chat->getId());
            $chatUser->setIduser($id);
            $em->persist($chatUser);
            $em->flush();
            array_push($chats,$chat);
            return $this->render('chat/conversation.html.twig', array(
                'chats' => $chats,
                'pseudo' => $pseudo,
                'form' => $form->createView(),
                'now' => $now,
            ));
        }
        return $this->render('chat/conversation.html.twig', array(
            'chats' => $chats,
            'pseudo' => $pseudo,
            'form' => $form->createView(),
            'now' => $now,
        ));
    }

    /**
     * @Route("/chat/{idchat}", name="chat")
     */
    public function chatMessageAction($idchat,Request $request)
    {
        $sess = $request->getSession();
        $id = $sess->get('id');
        $p = $sess->get('pseudo');
        $pseudo = $this->getDoctrine()->getRepository("AppBundle:salarie")->find($id);
        $messages = $this->getDoctrine()->getRepository('AppBundle:chatMessage')->findByIdchat($idchat);
        $chatName = $this->getDoctrine()->getRepository('AppBundle:chat')->find($idchat);
        $message = new chatMessage();
        $salarie=$this->getDoctrine()->getRepository('AppBundle:salarie')->findAll();
        $participants = $this->getDoctrine()->getRepository('AppBundle:chatUser')->findByIdchat($idchat);
        $nomParticipants = array();
        foreach ($participants as $part){
                array_push($nomParticipants,$this->getDoctrine()->getRepository('AppBundle:salarie')->find($part->getIduser()) );
        }

        $form = $this->createFormBuilder($message)
            ->add('contenu',TextType::class)
            ->getForm();
        $form->handleRequest($request);

        $form2 = $this->createFormBuilder()
            ->add('nom',TextType::class)
            ->getForm();
        $form2->handleRequest($request);

        if($form2->isSubmitted() && $form2->isValid()) {
            $contenu = $form2['nom']->getData();
            $user = $this->getDoctrine()->getRepository('AppBundle:user')->findOneByPseudo($contenu);
            if($user) {
                $newChatUser = new chatUser();
                $newChatUser->setIduser($user->getId());
                $newChatUser->setIdchat($idchat);
                $em = $this->getDoctrine()->getManager();
                $em->persist($newChatUser);
                $em->flush();

                array_push($nomParticipants, $this->getDoctrine()->getRepository('AppBundle:salarie')->find($user->getId()));
            }
        }

        if($form->isSubmitted() && $form->isValid()) {
            $contenu = $form['contenu']->getData();
            $message->setIdchat($idchat);
            $message->setContenu($contenu);
            $message->setUser($p);
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            array_push($messages,$message);
        }
        return $this->render('chat/conversation.html.twig', array(
            'messages' => $messages,
            'pseudo' => $p,
            'form' => $form->createView(),
            'form2' => $form2->createView(),
            'chatName'=>$chatName->getNom(),
            'participants'=>$nomParticipants

        ));
    }

    /**
     * @Route("/chat/remove/{idchat}", name="/chat/remove")
     */
    public function removeConvertationAction($idchat,Request $request)
    {

        $messages = $this->getDoctrine()->getRepository('AppBundle:chatMessage')->findByIdchat($idchat);
        $allChatUser = $this->getDoctrine()->getRepository('AppBundle:chatUser')->findByIdchat($idchat);
        $em = $this->getDoctrine()->getManager();
        foreach ($messages as $m){
            $em->remove($m);
            $em->flush();
        }
        foreach ($allChatUser as $a){
            $em->remove($a);
            $em->flush();
        }
        $chat = $this->getDoctrine()->getRepository('AppBundle:chat')->find($idchat);
        $em->remove($chat);
        $em->flush();
        return $this->redirectToRoute('/chat');




    }

 }