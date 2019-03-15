<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\Designer;
use App\Entity\Developer;
use App\Entity\TypeDesigner;
use App\Form\DesignerType;
use App\Form\DesignerTypesType;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;

/**
 * Language Controller
 * @Rest\Route("/api")
 */

class DesignerController extends FOSRestController
{
    /**
     * @Rest\Get("/designer", name="designer_list")
     */
    public function getListAction()
    {
        $repository = $this->getDoctrine()->getRepository(Designer::class);
        $designers = $repository->findAll();
        ##TODO: Fix me "A circular reference has been detected when serializine"
        foreach ($designers as $designer){
            $result[] = $designer->customSerialize();
        }
        return $this->handleView($this->view((isset($result)) ? $result : null));
    }

    /**
     * @Rest\Post("/designer", name="designer_new")
     * @param Request $request
     * @return Response
     */
    public function postDeveloperAction(Request $request)
    {
        $designer = new Designer();
        $data = json_decode($request->getContent(), true);

        $form = $this->createForm(DesignerType::class, $designer);

        if(isset($data['company_id'])){
            $companyRepository = $this->getDoctrine()->getRepository(Company::class);
            $company = $companyRepository->find($data['company_id']);
            $designer->setCompany($company);
        }else{
            return $this->handleView($this->view(['status' => 'Error | "company_id" is Required'], Response::HTTP_BAD_REQUEST));
        }

        if(isset($data['desing_type_id'])){
            $typeDesignerRepository = $this->getDoctrine()->getRepository(TypeDesigner::class);
            $typeDesigner = $typeDesignerRepository->find($data['desing_type_id']);
            $designer->setTypes($typeDesigner);
        }else{
            return $this->handleView($this->view(['status' => 'Error | "desing_type_id" is Required'], Response::HTTP_BAD_REQUEST));
        }

        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($designer);
            $em->flush();
            return $this->handleView($this->view($designer->customSerialize(), Response::HTTP_CREATED));
        }
        return $this->handleView($this->view($form->getErrors()));
    }

    /**
     * @Rest\Get("/designer/{id}", name="designer_show")
     * @param $id
     * @return Response
     */
    public function getDeveloperAction($id)
    {
        $repository = $this->getDoctrine()->getRepository(Designer::class);
        $designer = $repository->find($id);
        return $this->handleView($this->view($designer));
    }

    /**
     * @Rest\Put("/designer/{id}", name="designer_edit")
     *
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function putDeveloperAction($id, Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Designer::class);
        $designer = $repository->find($id);

        $data = json_decode($request->getContent(), true);

        $form = $this->createForm(DesignerType::class, $designer);

        if(isset($data['company_id'])){
            $companyRepository = $this->getDoctrine()->getRepository(Company::class);
            $company = $companyRepository->find($data['company_id']);
            $designer->setCompany($company);
        }else{
            return $this->handleView($this->view(['status' => 'Error | "company_id" is Required'], Response::HTTP_BAD_REQUEST));
        }

        if(isset($data['desing_type_id'])){
            $typeDesignerRepository = $this->getDoctrine()->getRepository(TypeDesigner::class);
            $typeDesigner = $typeDesignerRepository->find($data['desing_type_id']);
            $designer->setTypes($typeDesigner);
        }else{
            return $this->handleView($this->view(['status' => 'Error | "desing_type_id" is Required'], Response::HTTP_BAD_REQUEST));
        }

        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($designer);
            $em->flush();
            return $this->handleView($this->view($designer->customSerialize(), Response::HTTP_OK));
        }
        return $this->handleView($this->view($form->getErrors()));
    }

    /**
     * @param $id
     * @return Response
     *
     * @Rest\Delete("/designer/{id}", name="designer_delete")
     */
    public function deleteCompanyAction($id)
    {
        $repository = $this->getDoctrine()->getRepository(Company::class);
        $company = $repository->find($id);

        $repository->delete($company);

        return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_OK));
    }

}
