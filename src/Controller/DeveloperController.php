<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\Developer;
use App\Entity\Language;
use App\Form\DeveloperType;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;

/**
 * Language Controller
 * @Rest\Route("/api")
 */

class DeveloperController extends FOSRestController
{
    /**
     * @Rest\Get("/developer", name="developer_list")
     */
    public function getListAction()
    {
        $repository = $this->getDoctrine()->getRepository(Developer::class);
        $developers = $repository->findAll();

        ##TODO: Fix me "A circular reference has been detected when serializine"
        foreach ($developers as $developer){
            $result[] = $developer->customSerialize();
        }
        return $this->handleView($this->view((isset($result)) ? $result : null));
    }

    /**
     * @Rest\Post("/developer", name="developer_new")
     * @param Request $request
     * @return Response
     */
    public function postDeveloperAction(Request $request)
    {
        $developer = new Developer();
        $data = json_decode($request->getContent(), true);

        $form = $this->createForm(DeveloperType::class, $developer);

        if(isset($data['company_id'])){
            $companyRepository = $this->getDoctrine()->getRepository(Company::class);
            $company = $companyRepository->find($data['company_id']);
            $developer->setCompany($company);
        }else{
            return $this->handleView($this->view(['status' => 'Error | "company_id" is Required'], Response::HTTP_BAD_REQUEST));
        }

        if(isset($data['language_id'])){
            $languageRepository = $this->getDoctrine()->getRepository(Language::class);
            $language = $languageRepository->find($data['language_id']);
            $developer->setLanguage($language);
        }else{
            return $this->handleView($this->view(['status' => 'Error | "language_id" is Required'], Response::HTTP_BAD_REQUEST));
        }

        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($developer);
            $em->flush();
            return $this->handleView($this->view($developer->customSerialize(), Response::HTTP_CREATED));
        }
        return $this->handleView($this->view($form->getErrors()));
    }

    /**
     * @Rest\Get("/developer/{id}", name="developer_show")
     * @param $id
     * @return Response
     */
    public function getDeveloperAction($id)
    {
        $repository = $this->getDoctrine()->getRepository(Developer::class);
        $developer = $repository->find($id);
        return $this->handleView($this->view($developer->customSerialize()));
    }

    /**
     * @Rest\Put("/developer/{id}", name="developer_edit")
     *
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function putDeveloperAction($id, Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Developer::class);
        $developer = $repository->find($id);

        $data = json_decode($request->getContent(), true);

        $form = $this->createForm(DeveloperType::class, $developer);

        if(isset($data['company_id'])){
            $companyRepository = $this->getDoctrine()->getRepository(Company::class);
            $company = $companyRepository->find($data['company_id']);
            $developer->setCompany($company);
        }else{
            return $this->handleView($this->view(['status' => 'Error | "company_id" is Required'], Response::HTTP_BAD_REQUEST));
        }

        if(isset($data['language_id'])){
            $languageRepository = $this->getDoctrine()->getRepository(Language::class);
            $language = $languageRepository->find($data['language_id']);
            $developer->setLanguage($language);
        }else{
            return $this->handleView($this->view(['status' => 'Error | "language_id" is Required'], Response::HTTP_BAD_REQUEST));
        }

        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($developer);
            $em->flush();
            return $this->handleView($this->view($developer->customSerialize(), Response::HTTP_OK));
        }
        return $this->handleView($this->view($form->getErrors()));
    }

    /**
     * @param $id
     * @return Response
     *
     * @Rest\Delete("/developer/{id}", name="developer_delete")
     */
    public function deleteCompanyAction($id)
    {
        $repository = $this->getDoctrine()->getRepository(Company::class);
        $company = $repository->find($id);

        $repository->delete($company);

        return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_OK));
    }


}
