<?php
namespace Knp\KnoodleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="answer")
 */
Class Answer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="author_first_name", type="text", length=255)
     */
    private $authorFirstname;

    /**
     * @ORM\Column(name="author_last_name", type="text", length=255)
     */
    private $authorLastname;

    /**
     * @ORM\Column(name="author_email", type="text", length=255)
     */
    private $authorEmail;

    /**
     * @ORM\COlumn(type="integer")
     */
    private $choice;

    /**
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="answers")
     */
    private $question;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getAuthorFirstname()
    {
        return $this->authorFirstname;
    }

    public function setAuthorFirstname($authorFirstname)
    {
        $this->authorFirstname = $authorFirstname;
        return $this;
    }

    public function getAuthorLastname()
    {
        return $this->authorLastname;
    }

    public function setAuthorLastname($authorLastname)
    {
        $this->authorLastname = $authorLastname;
        return $this;
    }

    public function getAuthorEmail()
    {
        return $this->authorEmail;
    }

    public function setAuthorEmail($authorEmail)
    {
        $this->authorEmail = $authorEmail;
        return $this;
    }

    public function getChoice()
    {
        return $this->choice;
    }

    public function setChoice($choice)
    {
        $this->choice = $choice;
        return $this;
    }

    public function setQuestion(Question $question = null)
    {
        $this->question = $question;

        return $this;
    }

    public function getQuestion()
    {
        return $this->question;
    }
}
