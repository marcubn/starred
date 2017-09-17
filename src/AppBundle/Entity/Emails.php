<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Emails
 *
 * @ORM\Table(name="emails")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EmailsRepository")
 */
class Emails
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
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="page", type="string", length=255)
     */
    private $page;

    /**
     * @var int
     *
     * @ORM\Column(name="page_id", type="integer")
     */
    private $pageId;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_child", type="boolean")
     */
    private $isChild;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Emails
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set page
     *
     * @param string $page
     * @return Emails
     */
    public function setPage($page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get page
     *
     * @return string 
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set pageId
     *
     * @param integer $pageId
     * @return Emails
     */
    public function setPageId($pageId)
    {
        $this->pageId = $pageId;

        return $this;
    }

    /**
     * Get pageId
     *
     * @return integer 
     */
    public function getPageId()
    {
        return $this->pageId;
    }

    /**
     * Set isChild
     *
     * @param boolean $isChild
     * @return Emails
     */
    public function setIsChild($isChild)
    {
        $this->isChild = $isChild;

        return $this;
    }

    /**
     * Get isChild
     *
     * @return boolean 
     */
    public function getIsChild()
    {
        return $this->isChild;
    }
}
