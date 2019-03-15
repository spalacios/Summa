<?php

namespace App\Controller;

use App\Entity\Company;
use App\Form\CompanyType;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;

/**
 * Company Controller
 * @Rest\Route("/api")
 */

class CompanyController extends FOSRestController
{
    /**
     * @Rest\Get("/company", name="company_list")
     */
    public function getListAction()
    {
        $repository = $this->getDoctrine()->getRepository(Company::class);
        $companies = $repository->findAll();
        ##TODO: Fix me "A circular reference has been detected when serializine"
        foreach ($companies as $company){
            $result[] = $company->customSerialize();
        }
        return $this->handleView($this->view((isset($result)) ? $result : null));
    }

    /**
     * @Rest\Post("/company", name="company_new")
     * @param Request $request
     * @return Response
     */
    public function postCompanyAction(Request $request)
    {
        $company = new Company();
        $form = $this->createForm(CompanyType::class, $company);

        $data = json_decode($request->getContent(), true);

        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($company);
            $em->flush();
            return $this->handleView($this->view($company, Response::HTTP_CREATED));
        }
        return $this->handleView($this->view($form->getErrors()));
    }

    /**
     * @Rest\Get("/company/{id}", name="company_show")
     * @param $id
     * @return Response
     */
    public function getCompanyAction($id)
    {
        $repository = $this->getDoctrine()->getRepository(Company::class);
        $company = $repository->find($id);
        return $this->handleView($this->view($company->customSerialize()));
    }

    /**
     * @Rest\Put("/company/{id}", name="company_edit")
     *
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function putCompanyAction($id, Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Company::class);
        $company = $repository->find($id);

        $form = $this->createForm(CompanyType::class, $company);

        $data = json_decode($request->getContent(), true);

        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($company);
            $em->flush();
            return $this->handleView($this->view($company->customSerialize(), Response::HTTP_OK));
        }
        return $this->handleView($this->view($form->getErrors()));
    }

    /**
     * @param $id
     * @return Response
     *
     * @Rest\Delete("/company/{id}", name="company_delete")
     */
    public function deleteCompanyAction($id)
    {
        $repository = $this->getDoctrine()->getRepository(Company::class);
        $company = $repository->find($id);

        $repository->delete($company);

        return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_OK));
    }
}
