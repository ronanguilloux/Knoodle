<?php

namespace Knp\KnoodleBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Knp\KnoodleBundle\Entity\Answer;
use Knp\KnoodleBundle\Entity\Question;

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
            ->findAll();

        return $this->render(
            'KnpKnoodleBundle:Survey:index.html.twig',
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

        return $this->render(
            'KnpKnoodleBundle:Survey:show.html.twig',
            ['survey' => $survey]
        );
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

        if($request->isMethod('POST')) {
            foreach($survey->getQuestions() as $question) {
                $authorFirstname = $request->request->get('author_first_name');
                $authorLastname = $request->request->get('author_last_name');
                $authorEmail = $request->request->get('author_email');
                $choice = $request->request->get('question_' . $question->getId());

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
                'knoodle_show',
                ['id' => $survey->getID()]
            ));
        }

        return $this->render(
            'KnpKnoodleBundle:Survey:answer.html.twig',
            ['survey' => $survey]
        );

    }

}

