<?php

namespace Knp\KnoodleBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\KnoodleBundle\Entity\Survey;
use Knp\KnoodleBundle\Entity\Question;

/**
 * Load some Sample Survey data object
 *
 * @see AbstractFixture
 *
 * @author KnpLabs <hello@knplabs.com>
 */
class SurveyData extends AbstractFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $authors = array(
            array('Sheldon', 'Cooper', 's.cooper@knplabs.com'),
            array('Troy', 'Hanson', 't.hanson@knplabs.com'),
            array('Jasmine', 'Jill', 'j.jill@knplabs.com'),
            array('Raphael', 'Young', 'r.young@knplabs.com'),
            array('Kellie', 'Hughes', 'k.hughes@knplabs.com'),
            array('Oscar', 'Cruz', 'o.cruz@knplabs.com'),
            array('Hector', 'Riddle', 'h.riddle@knplabs.com'),
            array('Gary', 'Joseph', 'g.joseph@knplabs.com'),
            array('Amanda', 'Luna', 'a.luna@knplabs.com'),
            array('David', 'Hines', 'd.hines@knplabs.com'),
        );

        // create surveys
        for ($i = 0; $i < 10; $i++) {
            $survey = new Survey();
            $survey->setName(sprintf('The survey number %d', $i + 1));
            $survey->setAuthorFirstname($authors[$i][0]);
            $survey->setAuthorLastname($authors[$i][1]);
            $survey->setAuthorEmail($authors[$i][2]);
            $survey->setCreatedAt(new \DateTime(sprintf('- %d minutes', (11 - $i) * 129)));

            // create survey questions
            for ($j = 0; $j < 5; $j++) {
                $question = new Question();
                $question->setSentence(sprintf('The question number %d', $j + 1));
                $question->setFirstChoice('The first choice');
                $question->setSecondChoice('The second choice');
                $question->setThirdChoice('The third choice');

                $survey->addQuestion($question);

                $manager->persist($question);
            }

            $manager->persist($survey);
        }

        $manager->flush();
    }
}