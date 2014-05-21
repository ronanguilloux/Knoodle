<?php

namespace Knp\KnoodleBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Form;

use Knp\KnoodleBundle\Entity\Answer;
use Knp\KnoodleBundle\Entity\Question;
use Knp\KnoodleBundle\Form\Type\SurveyAnswerType;

class SurveyController extends Controller
{

    /**
     * findSurveyOr404
     *
     * @param int $id
     * @return Survey
     */
    private function findSurveyOr404($id)
    {
        $survey = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('KnpKnoodleBundle:Survey')
            ->find($id);

        if(null === $survey) {
            throw $this->createNotFoundException('No Survey :-\\');
        }

        return $survey;
    }

    /**
     * indexAction
     *
     * @return Response
     */
    public function indexAction()
    {

        $surveys = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('KnpKnoodleBundle:Survey')
            ->findAllOrderByCreation();

        return ['surveys' => $surveys];

        return $this->render(
            'KnpKnoodleBundle:Survey:index.html.twig',
            [
                'surveys' => $surveys
            ]
        );
    }


    public function latestAction($limit = 10)
    {
        $limit = (int)$limit > 0 ? (int)$limit : 1;
        $surveys = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('KnpKnoodleBundle:Survey')
            ->findAllOrderByCreationLimitedBy($limit);
        ;

        return $this->render(
            'KnpKnoodleBundle:Survey:_latest.html.twig',
            ['surveys' => $surveys]
        );
    }

    /**
     * popularAction
     *
     * @return Response
     */
    public function popularAction($_format)
    {
        $surveys = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('KnpKnoodleBundle:Survey')
            ->findAllPopular()
        ;

        return ['surveys' => $surveys];

        /*

        // The goold old way:

        if('html' !== $_format) {
            return $this->buildResponse(
                'KnpKnoodleBUndle:Survey:popular.html.twig',
                ['surveys' => $surveys],
                $_format // given in method param
            );
        }

        return $this->render(
            $surveys,
            [],
            $_format
        );
        */
    }

    /**
     * searchAction
     *
     * @return Response
     */
    public function searchAction(Request $request)
    {
        $name = $request->query->get('q', '');
        $surveys = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('KnpKnoodleBundle:Survey')
            ->findAllOrderByCreationAndNamedLike($name)
        ;

        return ['surveys' => $surveys];

        return $this->render(
            'KnpKnoodleBundle:Survey:search.html.twig',
            ['surveys' => $surveys]
        );
    }

    /**
     * showAction
     *
     * @param int $id
     * @return Response
     */
    public function showAction($id)
    {
        $survey = $this->findSurveyOr404($id);
        return ['survey' => $survey];

        /*
        return $this->render(
            'KnpKnoodleBundle:Survey:show.html.twig',
            ['survey' => $survey]
        );
        */
    }

    /**
     * answerAction
     *
     * @param int $id
     * @return void
     */
    public function answerAction(Request $request, $id)
    {
        $survey = $this->findSurveyOr404($id);

        $manager = $this
            ->getDoctrine()
            ->getManager()
        ;

        $form = $this->createForm(new SurveyAnswerType, null, ['survey' => $survey]);

        $form->handleRequest($request);

        if($form->isValid()) {
            $authorFirstname = $form->get('first_name')->getData();
            $authorLastname = $form->get('last_name')->getData();
            $authorEmail = $form->get('email')->getData();

            foreach($survey->getQuestions() as $question) {
                $choice = $form->get('choices')->get('question_' . $question->getId())->getData();
                $answer = (new Answer)
                    ->setAuthorFirstname($authorFirstname)
                    ->setAuthorLastName($authorLastname)
                    ->setAuthorEmail($authorEmail)
                    ->setChoice($choice)
                ;

                $question->addAnswer($answer);
                $manager->persist($question);
            }

            $manager->flush();

            $request
                ->getSession()
                ->getFlashBag()
                ->add('success' , 'Thanks!');

            $this->redirect($this->generateUrl(
                'knoodle_show', ['id'   => $survey->getID()]
            ));
        }

        return $this->render(
            'KnpKnoodleBundle:Survey:answer.html.twig',
            ['survey' => $survey, 'form' => $form->createView()]
        );
    }
}

