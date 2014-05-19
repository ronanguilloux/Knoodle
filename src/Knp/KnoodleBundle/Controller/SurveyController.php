<?php

namespace Knp\KnoodleBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

class SurveyController
{
    public function indexAction()
    {
        return new Response('test ?');
    }
}

