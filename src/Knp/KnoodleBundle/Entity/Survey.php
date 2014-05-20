<?php
/**
 * Created by PhpStorm.
 * User: ronan
 * Date: 19/05/2014
 * Time: 17:48
 */

namespace Knp\KnoodleBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Knp\KnoodleBundle\Entity\Question;


/**
 * @ORM\Entity
 * @ORM\Table(name="survey")
 */
Class Survey
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column
     */
    private $name;

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
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="Question", mappedBy="survey", cascade={"persist", "remove"})
     */
    private $questions;


    public function __construct()
    {
        $this->createdAt = new \DateTime;
        $this->questions = new ArrayCollection;
    }

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

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }



    public function getQuestions()
    {
        return $this->questions->toArray();
    }


    /**
     * Add questions
     *
     * @param \Knp\KnoodleBundle\Entity\Question $questions
     * @return Survey
     */
    public function addQuestion(\Knp\KnoodleBundle\Entity\Question $questions)
    {
        $this->questions[] = $questions;
        $questions->setSurvey($this);
        return $this;
    }

    /**
     * Remove questions
     *
     * @param \Knp\KnoodleBundle\Entity\Question $questions
     */
    public function removeQuestion(\Knp\KnoodleBundle\Entity\Question $questions)
    {
        $this->questions->removeElement($questions);
    }


}
