<?php

namespace BackendBundle\Entity;

/**
 * User
 */
class User
{
    /**
     * @var integer
     */
    private $idUser;

    /**
     * @var string
     */
    private $rolUser;

    /**
     * @var string
     */
    private $nameUser;

    /**
     * @var string
     */
    private $unameUser;

    /**
     * @var string
     */
    private $emailUser;

    /**
     * @var string
     */
    private $passwUser;

    /**
     * @var string
     */
    private $imageUser;

    /**
     * @var \DateTime
     */
    private $createUser;


    /**
     * Get idUser
     *
     * @return integer
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set rolUser
     *
     * @param string $rolUser
     *
     * @return User
     */
    public function setRolUser($rolUser)
    {
        $this->rolUser = $rolUser;

        return $this;
    }

    /**
     * Get rolUser
     *
     * @return string
     */
    public function getRolUser()
    {
        return $this->rolUser;
    }

    /**
     * Set nameUser
     *
     * @param string $nameUser
     *
     * @return User
     */
    public function setNameUser($nameUser)
    {
        $this->nameUser = $nameUser;

        return $this;
    }

    /**
     * Get nameUser
     *
     * @return string
     */
    public function getNameUser()
    {
        return $this->nameUser;
    }

    /**
     * Set unameUser
     *
     * @param string $unameUser
     *
     * @return User
     */
    public function setUnameUser($unameUser)
    {
        $this->unameUser = $unameUser;

        return $this;
    }

    /**
     * Get unameUser
     *
     * @return string
     */
    public function getUnameUser()
    {
        return $this->unameUser;
    }

    /**
     * Set emailUser
     *
     * @param string $emailUser
     *
     * @return User
     */
    public function setEmailUser($emailUser)
    {
        $this->emailUser = $emailUser;

        return $this;
    }

    /**
     * Get emailUser
     *
     * @return string
     */
    public function getEmailUser()
    {
        return $this->emailUser;
    }

    /**
     * Set passwUser
     *
     * @param string $passwUser
     *
     * @return User
     */
    public function setPasswUser($passwUser)
    {
        $this->passwUser = $passwUser;

        return $this;
    }

    /**
     * Get passwUser
     *
     * @return string
     */
    public function getPasswUser()
    {
        return $this->passwUser;
    }

    /**
     * Set imageUser
     *
     * @param string $imageUser
     *
     * @return User
     */
    public function setImageUser($imageUser)
    {
        $this->imageUser = $imageUser;

        return $this;
    }

    /**
     * Get imageUser
     *
     * @return string
     */
    public function getImageUser()
    {
        return $this->imageUser;
    }

    /**
     * Set createUser
     *
     * @param \DateTime $createUser
     *
     * @return User
     */
    public function setCreateUser($createUser)
    {
        $this->createUser = $createUser;

        return $this;
    }

    /**
     * Get createUser
     *
     * @return \DateTime
     */
    public function getCreateUser()
    {
        return $this->createUser;
    }
}

