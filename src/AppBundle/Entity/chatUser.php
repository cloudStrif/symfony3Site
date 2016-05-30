<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * chatUser
 *
 * @ORM\Table(name="chat_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\chatUserRepository")
 */
class chatUser
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
     * @var int
     *
     * @ORM\Column(name="iduser", type="integer")
     */
    private $iduser;


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
     * @return chatUser
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
     * Set iduser
     *
     * @param integer $iduser
     *
     * @return chatUser
     */
    public function setIduser($iduser)
    {
        $this->iduser = $iduser;

        return $this;
    }

    /**
     * Get iduser
     *
     * @return int
     */
    public function getIduser()
    {
        return $this->iduser;
    }
}

