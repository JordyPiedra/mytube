<?php

namespace BackendBundle\Entity;

/**
 * Comment
 */
class Comment
{
    /**
     * @var integer
     */
    private $idComment;

    /**
     * @var string
     */
    private $bodyComment;

    /**
     * @var \DateTime
     */
    private $createComment = 'CURRENT_TIMESTAMP';

    /**
     * @var \BackendBundle\Entity\User
     */
    private $idUser;

    /**
     * @var \BackendBundle\Entity\Video
     */
    private $idVideo;


    /**
     * Get idComment
     *
     * @return integer
     */
    public function getIdComment()
    {
        return $this->idComment;
    }

    /**
     * Set bodyComment
     *
     * @param string $bodyComment
     *
     * @return Comment
     */
    public function setBodyComment($bodyComment)
    {
        $this->bodyComment = $bodyComment;

        return $this;
    }

    /**
     * Get bodyComment
     *
     * @return string
     */
    public function getBodyComment()
    {
        return $this->bodyComment;
    }

    /**
     * Set createComment
     *
     * @param \DateTime $createComment
     *
     * @return Comment
     */
    public function setCreateComment($createComment)
    {
        $this->createComment = $createComment;

        return $this;
    }

    /**
     * Get createComment
     *
     * @return \DateTime
     */
    public function getCreateComment()
    {
        return $this->createComment;
    }

    /**
     * Set idUser
     *
     * @param \BackendBundle\Entity\User $idUser
     *
     * @return Comment
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

    /**
     * Set idVideo
     *
     * @param \BackendBundle\Entity\Video $idVideo
     *
     * @return Comment
     */
    public function setIdVideo(\BackendBundle\Entity\Video $idVideo = null)
    {
        $this->idVideo = $idVideo;

        return $this;
    }

    /**
     * Get idVideo
     *
     * @return \BackendBundle\Entity\Video
     */
    public function getIdVideo()
    {
        return $this->idVideo;
    }
}

