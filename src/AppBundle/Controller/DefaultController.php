<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\Model;
use FOS\RestBundle\View\View;
use Swagger\Annotations as SWG;

class DefaultController extends FOSRestController
{
    /**
     * @Route("/", name="homepage")
     */
    public function getAction(Request $request)
    {
        return new View('Greetings!');
    }
}