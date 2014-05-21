<?php

namespace Knp\KnoodleBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class SurveyAnswerType extends AbstractType
{

    public function getName()
    {
        return 'survey_name';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(['survey']);
        $resolver->setAllowedTypes(['survey' => 'Knp\KnoodleBundle\Entity\Survey']);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $choicesBuilder = $builder
            ->add('first_name', 'text')
            ->add('last_name', 'text')
            ->add('email', 'email')
            ->add('choices', 'form')
            ->get('choices')
            ;

        $survey = $options['survey'];

        foreach($survey->getQuestions() as $question) {
            $choicesBuilder->add(
                'question_' . $question->getId(),
                'choice',
                [
                    'multiple' => false,
                    'expanded' => true,
                    'choices'  => $question->getChoices(),
                    'label'    => $question->getSentence()
                ]
            )
            ;
        }

        $builder->add('validate', 'submit');

    }

}
