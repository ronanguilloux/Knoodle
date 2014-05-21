<?php

namespace spec\Knp\KnoodleBundle\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class QuestionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\KnoodleBundle\Entity\Question');
    }

    function it_contains_the_choices($args)
    {
        $this->setFirstChoice('plop ?');
        $this->setSecondChoice('plip ?');
        $this->setThirdChoice('plup ?');

        $this
            ->getChoices()
            ->shouldReturn([
            1 => 'plop ?',
            2 => 'plip ?',
            3 => 'plup ?'
            ])
        ;

        $this->setFirstChoice('un ?');
        $this->setSecondChoice('deux ?');
        $this->setThirdChoice('trois ?');

        $this
            ->getChoices()
            ->shouldReturn([
            1 => 'un ?',
            2 => 'deux ?',
            3 => 'trois ?'
            ])
        ;


    }
}
