<?php

namespace Knp\KnoodleBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @ORM\Entity
 * @ORM\Table(name="question")
 */
Class Question
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column
     */
    private $sentence;

    /**
     * @ORM\Column(type="string",name="first_choice",length=255)
     */
    private $firstChoice;

    /**
     * @ORM\Column(type="string",name="second_choice",length=255)
     */
    private $secondChoice;

    /**
     * @ORM\Column(type="string",name="third_choice",length=255)
     */
    private $thirdChoice;

    /**
     * @ORM\ManyToOne(targetEntity="Survey", inversedBy="questions")
     * @var [type]
     */
    private $survey;

    /**
     * @ORM\OneToMany(targetEntity="Answer", mappedBy="question")
     */
    private $answers;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->answers = new ArrayCollection;
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

    public function getSentence()
    {
        return $this->sentence;
    }

    public function setSentence($sentence)
    {
        $this->sentence = $sentence;
        return $this;
    }

    public function getFirstChoice()
    {
        return $this->firstChoice;
    }

    public function setFirstChoice($firstChoice)
    {
        $this->firstChoice = $firstChoice;
        return $this;
    }

    public function getSecondChoice()
    {
        return $this->secondChoice;
    }

    public function setSecondChoice($secondChoice)
    {
        $this->secondChoice = $secondChoice;
        return $this;
    }

    public function getThirdChoice()
    {
        return $this->thirdChoice;
    }

    public function setThirdChoice($thirdChoice)
    {
        $this->thirdChoice = $thirdChoice;
        return $this;
    }

    public function getSurvey()
    {
        return $this->survey;
    }

    public function setSurvey(Survey $survey = null)
    {
        $this->survey = $survey;
        return $this;
    }

    public function addAnswer(\Knp\KnoodleBundle\Entity\Answer $answers)
    {
        $this->answers[] = $answers;
        $answers->setQuestion($this);
        return $this;
    }

    public function removeAnswer(\Knp\KnoodleBundle\Entity\Answer $answers)
    {
        $this->answers->removeElement($answers);
    }

    public function getAnswers()
    {
        return $this->answers;
    }


}
