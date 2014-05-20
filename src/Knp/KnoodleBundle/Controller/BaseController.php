<?php

namespace Knp\KnoodleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseController extends Controller
{

    /**
     * buildResponse
     *
     * @param mixed $subject: templatePath or data to serialize
     * @return Response
     */
    public function buildResponse($subject, array $arguments = [], $format = 'html', $responseCode = 200)
    {
        if('html' === $format) {
            return $this->render($subject, $arguments);
        }

        return new Response(
            $this->get('jsm_serializer')->serialize($subject, $format),
            $responseCode,
            ['Content-Type'] => 'json' === $format ? 'application/json' : 'application/xml']
        );
    }

}
