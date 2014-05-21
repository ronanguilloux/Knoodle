<?php

namespace spec\Knp\KnoodleBundle\Form\Type;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormBuilderInterface;

use Knp\KnoodleBundle\Entity\Survey;
use Knp\KnoodleBundle\Entity\Question;

class SurveyAnswerTypeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\KnoodleBundle\Form\Type\SurveyAnswerType');
    }

    function it_is_a_form_type()
    {
        $this->shouldHaveType('Symfony\Component\Form\AbstractType');
    }

    function it_creates_a_survey_answer_form(FormBuilderInterface $builder,
        FormBuilderInterface $choiceBuilder, Question $question, Survey $survey)
    {

        $question->getId()->willReturn(1)->shouldBeCalled();
        $question->getChoices()->willReturn([
            1 => 'first choice',
            2 => 'second choice',
            3 => 'third choice'
        ])->shouldBeCalled();
        $survey->addQuestion($question);
        $survey->getQuestions()->willReturn([$question])->shouldBeCalled();

        $builder->add('firstname','text')->shouldBeCalled()->willReturn($builder);
        $builder->add('lastname','text')->shouldBeCalled()->willReturn($builder);
        $builder->add('email','email')->shouldBeCalled()->willReturn($builder);
        $builder->add('choices','form')->shouldBeCalled()->willReturn($builder);
        $builder->add('validate','submit')->shouldBeCalled()->willReturn($builder);

        $builder->get('choices')->willReturn($choiceBuilder);

        $choiceBuilder()->add('question_1', 'choice', [
            'multiple' => false,
            'expanded' => true,
            'choices' => [
                1 => 'first choice',
                2 => 'second choice',
                3 => 'third choice'
                ]
            ])->shouldBeCalled();

        $this->buildForm($builder, [
            'survey' => $survey
        ]);
    }
}
