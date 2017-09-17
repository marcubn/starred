<?php

namespace AppBundle\Service;

use AppBundle\Entity\ChildPages;
use AppBundle\Entity\Emails;
use AppBundle\Entity\Pages;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DomCrawler\Crawler;

class PageCrawler
{
    const PATTERN = '/[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})/i';

    private $links = array();

    private $emails = array();

    private $parent_id = null;

    public function addLink($link) {
        $this->links[] = $link;
    }

    public function getLinks() {
        return $this->links;
    }

    public function addEmail($email, $link) {
        $this->emails[$email] = $link;
    }

    public function getEmails() {
        return $this->emails;
    }

    public function getParentId()
    {
        return $this->parent_id;
    }

    public function setParentId($parent_id)
    {
        $this->parent_id = $parent_id;
    }

    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * Could also use curl to get content
     * Choose the simplest method
     * @param $data
     * @return bool|string
     */
    public function getHtml($data)
    {
        return file_get_contents($data);
    }

    /**
     * @param $html
     * @return Crawler
     */
    public function parseHtml($html)
    {
        $crawler = new Crawler();
        $crawler->addHtmlContent($html);

        $crawler->filter('a')->each(function ($node, $i) {
            $this->addLink($node->attr('href'));
        });

        return $crawler;
    }

    /**
     * @param $html
     * @param $data
     */
    public function getCurrentPageEmails($html, $data)
    {
        preg_match_all(self::PATTERN, $html, $matches);
        $id = $this->savePage($data);
        foreach ($matches[0] as $email) {
            $this->addEmail($email, $data);
            $this->saveEmail($id, $email, $data);
        }
    }

    /**
     *
     */
    public function getChildEmailAddress()
    {
        foreach ($this->getLinks() as $link) {
            $html = $this->getHtml($link);
            preg_match_all(self::PATTERN, $html, $matches);
            $id = $this->savePage($link, true);
            foreach ($matches[0] as $email) {
                $this->addEmail($email, $link);
                $this->saveEmail($id, $email, $link, true);
            }
        }
    }

    public function savePage($link, $is_child = false)
    {
        if (!$is_child) {
            $page = new Pages();
            $page->setLink($link);
            $this->saveTodb($page);
            $id = $page->getId();
            $this->setParentId($id);
         } else {
            $page = new ChildPages();
            $page->setParentId($this->getParentId());
            $page->setLink($link);
            $this->saveTodb($page);
        }



        return $page->getId();
    }

    public function saveEmail($id, $email_addr, $link, $is_child = false)
    {
        $email = new Emails();
        $email->setEmail($email_addr);
        $email->setIsChild($is_child);
        $email->setPage($link);
        $email->setPageId($id);
        $this->saveTodb($email);
    }

    public function saveTodb($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }
}