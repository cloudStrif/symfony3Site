<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * formationUser
 *
 * @ORM\Table(name="formation_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\formationUserRepository")
 */
class formationUser
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
     * @ORM\Column(name="idformation", type="integer")
     */
    private $idformation;

    /**
     * @var int
     *
     * @ORM\Column(name="iduser", type="integer")
     */
    private $iduser;

    /**
     * @var int
     *
     * @ORM\Column(name="approuve", type="integer")
     */
    private $approuve;

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
     * Set idformation
     *
     * @param integer $idformation
     *
     * @return formationUser
     */
    public function setIdformation($idformation)
    {
        $this->idformation = $idformation;

        return $this;
    }

    /**
     * Get idformation
     *
     * @return int
     */
    public function getIdformation()
    {
        return $this->idformation;
    }

    /**
     * Set iduser
     *
     * @param integer $iduser
     *
     * @return formationUser
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
    /**
     * Set approuve
     *
     * @param integer $approuve
     *
     * @return formationApprouve
     */
    public function setApprouve($approuve)
    {
        $this->approuve = $approuve;

        return $this;
    }

    /**
     * Get iduser
     *
     * @return int
     */
    public function getApprouve()
    {
        return $this->approuve;
    }

    

}

