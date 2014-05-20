<?php

namespace Knp\KnoodleBundle\EventListener\Kernel;

use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\Serializer;

class ApiResponseListener
{

    private $twig;
    private $serializer;

    public function __construct(\Twig_Environment $twig, Serializer $serializer)
    {
        $this->twig       = $twig;
        $this->serializer = $serializer;
    }

    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        /*
            die(var_dump($event->getRequest()->attributes->all()));
            array (size=5)
            '_controller' => string 'Knp\KnoodleBundle\Controller\SurveyController::popularAction' (length=60)
            '_format' => string 'html' (length=4)
            '_locale' => string 'fr' (length=2)
            '_route' => string 'knoodle_popular' (length=15)
            '_route_params' =>
            array (size=2)
            '_format' => string 'html' (length=4)
            '_locale' => string 'fr' (length=2)/bin/bash: /usr/bin/phpcs: No such file or directory
         */
        $data       = $event->getControllerResult();
        $format     = $event->getRequest()->attributes->get('_format');
        $controller = $event->getRequest()->attributes->get('_controller');

        if('html' === $format) {
            $template = $this->guessTemplateName($controller);
            $content  = $this->twig->render($template, $data);
            $response = new Response($content, 200);

            $event->setResponse($response);
            return;
        }

        if(!in_array($format, ['json', 'xml'])) {
            throw new \Exception(sprintf("%s format is not supported yet!", $format));
        }

        $contentType = 'json' === $format ? 'applicatino/json' : 'application/xml';
        $data        = is_array($data) && count($data) === 1 ? array_shift($data) : $data;
        $content     = $this->serializer->serialize($data, $format);

        $event->setResponse(new Response($content, 200, ['Content-Type' => $contentType]));


    }


    private function guessTemplateName($controller)
    {
        $exploded            = explode('\\', $controller);
        $bundleMember        = [];
        $explodedController  = explode('::', array_pop($exploded));

        foreach($exploded as $member) {
            if('Controller' === $member) {
                break;
            }
            $bundleMember[] = $member;
        }

        $bundleName     = implode('', $bundleMember);
        $controllerName = str_replace('Controller', '', $explodedController[0]);
        $actionName     = str_replace('Action', '', $explodedController[1]);

        return sprintf(
            '%s:%s:%s.html.twig',
            $bundleName,
            $controllerName,
            $actionName
        );



    }

}
