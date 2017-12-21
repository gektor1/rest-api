<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Useless;
use AppBundle\Form\UselessType;

/**
 * @todo Fix SWG\Schema(ref="#/definitions/Useless") to do not add id to json
 */
class UselessController extends FOSRestController
{
    private $errorMessages = [
        'success' => 'Success',
        'no_record_exist' => 'There are no record(s) exist',
    ];
    
    /**
     * @Rest\Get("/api/useless")
     * @SWG\Response(
     *     response=200,
     *     description="Returns all usless",
     *     @SWG\Schema(
     *         type="array",
     *         @Model(type=AppBundle\Entity\Useless::class)
     *     )
     * )
     * @SWG\Tag(name="usless")
     */
    public function getAction()
    {
        $entities = $this->getDoctrine()->getRepository('AppBundle:Useless')->findAll();
        
        if (empty($entities)) {
            return new View($this->errorMessages['no_record_exist'], Response::HTTP_NOT_FOUND);
        }
        
        return $entities;
    }
    
    /**
     * @Rest\Get("/api/useless/{id}")
     * @SWG\Response(
     *     response=200,
     *     description="Returns the usless by id",
     *     @SWG\Schema(
     *         type="array",
     *         @Model(type=AppBundle\Entity\Useless::class)
     *     )
     * )
     * @SWG\Tag(name="usless")
     */
    public function idAction($id)
    {
        $row = $this->getDoctrine()->getRepository('AppBundle:Useless')->find($id);
        
        if ($row === null) {
            return new View($this->errorMessages['no_record_exist'], Response::HTTP_NOT_FOUND);
        }
        
        return $row;
    }

    /**
     * @Rest\Post("/api/useless")
     * @SWG\Post(
     *     path="/api/useless",
     *     tags={"usless"},
     *     summary="Add a new usless",
     *     description="",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         description="Usless object that needs to be added",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Useless"),
     *     ),
     *     @SWG\Response(
     *          response=200,
     *          description="Update useless",
     *          @SWG\Schema(
     *              type="array",
     *              @Model(type=AppBundle\Entity\Useless::class)
     *          )
     *     )
     * )
     */
    public function postAction(Request $request)
    {
        $useless = new Useless();
        return $this->processForm($useless, $request);
    }

    /**
     * @Rest\Put("/api/useless/{id}")
     * 
     * @SWG\Put(
     *     path="/api/useless/{id}",
     *     tags={"usless"},
     *     summary="Update usless",
     *     description="",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         description="Usless object that needs to be updated",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Useless"),
     *     ),
     *     @SWG\Response(
     *          response=200,
     *          description="Update useless",
     *          @SWG\Schema(
     *              type="array",
     *              @Model(type=AppBundle\Entity\Useless::class)
     *          )
     *     )
     * )
     */
    public function updateAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $useless = $em->getRepository('AppBundle:Useless')->find($id);
        
        if ($useless === null) {
            return new View($this->errorMessages['no_record_exist'], Response::HTTP_NOT_FOUND);
        }
        
        return $this->processForm($useless, $request);        
    }
    
    /**
     * @Rest\Patch("/api/useless/{id}")
     * @SWG\Patch(
     *     path="/api/useless/{id}",
     *     tags={"usless"},
     *     summary="Patch usless",
     *     description="",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         description="Usless object that needs to be updated",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Useless"),
     *     ),
     *     @SWG\Response(
     *          response=200,
     *          description="Update useless",
     *          @SWG\Schema(
     *              type="array",
     *              @Model(type=AppBundle\Entity\Useless::class)
     *          )
     *     )
     * )
     */
    public function patchAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $useless = $em->getRepository('AppBundle:Useless')->find($id);
        
        if ($useless === null) {
            return new View($this->errorMessages['no_record_exist'], Response::HTTP_NOT_FOUND);
        }
        
        return $this->processForm($useless, $request, false);   
    }

    /**
     * @Rest\Delete("/api/useless/{id}")
     * * @SWG\Response(
     *     response=200,
     *     description="Delete useless"
     * )
     * @SWG\Tag(name="usless")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Useless')->find($id);
        
        if ($entity === null) {
            return new View($this->errorMessages['no_record_exist'], Response::HTTP_NOT_FOUND);
        } 
        
        $em->remove($entity);
        $em->flush();
        
        return new View($this->errorMessages['success'], Response::HTTP_OK);
    }

    private function processForm($useless, $request, $clearMissing = true) {
        $em = $this->getDoctrine()->getManager();
        
        $form = $this->createForm(UselessType::class, $useless);
        $form->submit($request->request->all(), $clearMissing);
        
        if ($form->isValid()) {
            $em->flush();
            return $useless;
        }
        
        return new View($form->getErrors(), Response::HTTP_NOT_FOUND);      
    }
}
