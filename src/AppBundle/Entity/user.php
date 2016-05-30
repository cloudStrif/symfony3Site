<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * user
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\userRepository")
 */
class user
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
     * @var string
     *
     * @ORM\Column(name="pseudo", type="string", length=255)
     */
    private $pseudo;

    /**
     * @var string
     *
     * @ORM\Column(name="mdp", type="string", length=255)
     */
    private $mdp;

    /**
     * @var int
     *
     * @ORM\Column(name="jourFormation", type="integer", options={"default" = 90})
     */
    private $jourFormation;

    /**
     * @var boolean
     *
     * @ORM\Column(name="moderateur", type="boolean", options={"default"=false})
     */
    private $moderateur;

    /**
     * Set id
     *
     * @param int $id
     *
     * @return user
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
    
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
     * Set pseudo
     *
     * @param string $pseudo
     *
     * @return user
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Get pseudo
     *
     * @return string
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * Set mdp
     *
     * @param string $mdp
     *
     * @return user
     */
    public function setMdp($mdp)
    {
        $this->mdp = $mdp;

        return $this;
    }

    /**
     * Get mdp
     *
     * @return string
     */
    public function getMdp()
    {
        return $this->mdp;
    }

    /**
     * Set jourFormation
     *
     * @param integer $jourFormation
     *
     * @return user
     */
    public function setJourFormation($jourFormation)
    {
        $this->jourFormation = $jourFormation;

        return $this;
    }

    /**
     * Get jourFormation
     *
     * @return int
     */
    public function getJourFormation()
    {
        return $this->jourFormation;
    }

    /**
     * Get moderateur
     *
     * @return boolean
     */
    public function getModerateur()
    {
        return $this->moderateur;
    }
}
