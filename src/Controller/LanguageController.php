<?php

namespace App\Controller;

use App\Entity\Language;
use App\Form\LanguageType;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;

/**
 * Language Controller
 * @Rest\Route("/api")
 */

class LanguageController extends FOSRestController
{
    /**
     * @Rest\Get("/language", name="language_list")
     */
    public function getListAction()
    {
        $repository = $this->getDoctrine()->getRepository(Language::class);
        $languages = $repository->findAll();
        return $this->handleView($this->view($languages));
    }

    /**
     * @Rest\Post("/language", name="language_new")
     * @param Request $request
     * @return Response
     */
    public function postCompanyAction(Request $request)
    {
        $language = new Language();
        $form = $this->createForm(LanguageType::class, $language);

        $data = json_decode($request->getContent(), true);

        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($language);
            $em->flush();
            return $this->handleView($this->view($language, Response::HTTP_CREATED));
        }
        return $this->handleView($this->view($form->getErrors()));
    }

    /**
     * @Rest\Get("/language/{id}", name="language_show")
     * @param $id
     * @return Response
     */
    public function getCompanyAction($id)
    {
        $repository = $this->getDoctrine()->getRepository(Language::class);
        $language = $repository->find($id);
        return $this->handleView($this->view($language));
    }

    /**
     * @Rest\Put("/language/{id}", name="language_edit")
     *
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function putCompanyAction($id, Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Language::class);
        $language = $repository->find($id);

        $form = $this->createForm(LanguageType::class, $language);

        $data = json_decode($request->getContent(), true);

        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($language);
            $em->flush();
            return $this->handleView($this->view($language, Response::HTTP_OK));
        }
        return $this->handleView($this->view($form->getErrors()));
    }

    /**
     * @param $id
     * @return Response
     *
     * @Rest\Delete("/language/{id}", name="language_delete")
     */
    public function deleteCompanyAction($id)
    {
        $repository = $this->getDoctrine()->getRepository(Language::class);
        $language = $repository->find($id);

        $repository->delete($language);

        return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_OK));
    }
}