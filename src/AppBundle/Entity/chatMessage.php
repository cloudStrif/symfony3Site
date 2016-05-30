<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * chatMessage
 *
 * @ORM\Table(name="chat_message")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\chatMessageRepository")
 */
class chatMessage
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="idchat", type="integer")
     */
    private $idchat;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="string", length=255)
     */
    private $contenu;

    /**
     * @var string
     *
     * @ORM\Column(name="user", type="string", length=255)
     */
    private $user;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idchat
     *
     * @param integer $idchat
     *
     * @return chatMessage
     */
    public function setIdchat($idchat)
    {
        $this->idchat = $idchat;

        return $this;
    }

    /**
     * Get idchat
     *
     * @return int
     */
    public function getIdchat()
    {
        return $this->idchat;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return chatMessage
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set user
     *
     * @param string $user
     *
     * @return chatMessage
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }
}

