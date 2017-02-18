<?php

namespace BackendBundle\Entity;

/**
 * Video
 */
class Video
{
    /**
     * @var integer
     */
    private $idVideo;

    /**
     * @var string
     */
    private $titleVideo;

    /**
     * @var string
     */
    private $descriptionVideo;

    /**
     * @var string
     */
    private $statusVideo;

    /**
     * @var string
     */
    private $imageVideo;

    /**
     * @var string
     */
    private $pathVideo;

    /**
     * @var \DateTime
     */
    private $createUser;

    /**
     * @var \DateTime
     */
    private $updateUser;

    /**
     * @var \BackendBundle\Entity\User
     */
    private $idUser;


    /**
     * Get idVideo
     *
     * @return integer
     */
    public function getIdVideo()
    {
        return $this->idVideo;
    }

    /**
     * Set titleVideo
     *
     * @param string $titleVideo
     *
     * @return Video
     */
    public function setTitleVideo($titleVideo)
    {
        $this->titleVideo = $titleVideo;

        return $this;
    }

    /**
     * Get titleVideo
     *
     * @return string
     */
    public function getTitleVideo()
    {
        return $this->titleVideo;
    }

    /**
     * Set descriptionVideo
     *
     * @param string $descriptionVideo
     *
     * @return Video
     */
    public function setDescriptionVideo($descriptionVideo)
    {
        $this->descriptionVideo = $descriptionVideo;

        return $this;
    }

    /**
     * Get descriptionVideo
     *
     * @return string
     */
    public function getDescriptionVideo()
    {
        return $this->descriptionVideo;
    }

    /**
     * Set statusVideo
     *
     * @param string $statusVideo
     *
     * @return Video
     */
    public function setStatusVideo($statusVideo)
    {
        $this->statusVideo = $statusVideo;

        return $this;
    }

    /**
     * Get statusVideo
     *
     * @return string
     */
    public function getStatusVideo()
    {
        return $this->statusVideo;
    }

    /**
     * Set imageVideo
     *
     * @param string $imageVideo
     *
     * @return Video
     */
    public function setImageVideo($imageVideo)
    {
        $this->imageVideo = $imageVideo;

        return $this;
    }

    /**
     * Get imageVideo
     *
     * @return string
     */
    public function getImageVideo()
    {
        return $this->imageVideo;
    }

    /**
     * Set pathVideo
     *
     * @param string $pathVideo
     *
     * @return Video
     */
    public function setPathVideo($pathVideo)
    {
        $this->pathVideo = $pathVideo;

        return $this;
    }

    /**
     * Get pathVideo
     *
     * @return string
     */
    public function getPathVideo()
    {
        return $this->pathVideo;
    }

    /**
     * Set createUser
     *
     * @param \DateTime $createUser
     *
     * @return Video
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

    /**
     * Set updateUser
     *
     * @param \DateTime $updateUser
     *
     * @return Video
     */
    public function setUpdateUser($updateUser)
    {
        $this->updateUser = $updateUser;

        return $this;
    }

    /**
     * Get updateUser
     *
     * @return \DateTime
     */
    public function getUpdateUser()
    {
        return $this->updateUser;
    }

    /**
     * Set idUser
     *
     * @param \BackendBundle\Entity\User $idUser
     *
     * @return Video
     */
    public function setIdUser(\BackendBundle\Entity\User $idUser = null)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return \BackendBundle\Entity\User
     */
    public function getIdUser()
    {
        return $this->idUser;
    }
}

