<?php

namespace App\Controller;

use App\Entity\DesignerType;
use App\Entity\TypeDesigner;
use App\Form\DesignerTypesType;
use App\Form\TypeDesignerType;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;

/**
 * Language Controller
 * @Rest\Route("/api")
 */

class TypeDesignerController extends FOSRestController
{
    /**
     * @Rest\Get("/designer-type", name="designer_type_list")
     */
    public function getListAction()
    {
        $repository = $this->getDoctrine()->getRepository(TypeDesigner::class);
        $designerTypes = $repository->findAll();
        return $this->handleView($this->view($designerTypes));
    }

    /**
     * @Rest\Post("/designer-type", name="designer_type_new")
     * @param Request $request
     * @return Response
     */
    public function postCompanyAction(Request $request)
    {
        $desingType = new TypeDesigner();
        $form = $this->createForm(TypeDesignerType::class, $desingType);

        $data = json_decode($request->getContent(), true);

        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($desingType);
            $em->flush();
            return $this->handleView($this->view($desingType, Response::HTTP_CREATED));
        }
        return $this->handleView($this->view($form->getErrors()));
    }

    /**
     * @Rest\Get("/designer-type/{id}", name="designer_type_show")
     * @param $id
     * @return Response
     */
    public function getCompanyAction($id)
    {
        $repository = $this->getDoctrine()->getRepository(TypeDesigner::class);
        $desingType = $repository->find($id);
        return $this->handleView($this->view($desingType));
    }

    /**
     * @Rest\Put("/designer-type/{id}", name="designer_type_edit")
     *
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function putCompanyAction($id, Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(TypeDesigner::class);
        $desingType = $repository->find($id);

        $form = $this->createForm(TypeDesignerType::class, $desingType);

        $data = json_decode($request->getContent(), true);

        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($desingType);
            $em->flush();
            return $this->handleView($this->view($desingType, Response::HTTP_OK));
        }
        return $this->handleView($this->view($form->getErrors()));
    }

    /**
     * @param $id
     * @return Response
     *
     * @Rest\Delete("/designer-type/{id}", name="designer_type_delete")
     */
    public function deleteCompanyAction($id)
    {
        $repository = $this->getDoctrine()->getRepository(DesignerType::class);
        $desingType = $repository->find($id);

        $repository->delete($desingType);

        return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_OK));
    }
}
