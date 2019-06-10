<?php

namespace InterimBundle\Controller;

use InterimBundle\Entity\Contract;
use InterimBundle\Entity\MissionMonitor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Contract controller.
 *
 * @Route("contract")
 */
class ContractController extends Controller
{
    /**
     * Lists all contract entities.
     *
     * @Route("/", name="contract_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $contracts = $em->getRepository('InterimBundle:Contract')->findAll();

        return $this->render('@Interim/contract/index.html.twig', array(
            'contracts' => $contracts,
        ));
    }

    /**
     * Creates a new contract entity.
     *
     * @Route("/new", name="contract_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $contract = new Contract();
        $form = $this->createForm('InterimBundle\Form\ContractType', $contract);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contract);
            $em->flush();
            // we create a new mission monitor to note the interim
            $mission = new MissionMonitor();
            $mission->setContract($contract);
            $mission->setInterim($contract->getInterim());
            $em->persist($mission);
            $em->flush();

            return $this->redirectToRoute('contract_show', array('id' => $contract->getId()));
        }

        return $this->render('@Interim/contract/new.html.twig', array(
            'contract' => $contract,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a contract entity.
     *
     * @Route("/{id}", name="contract_show")
     * @Method("GET")
     */
    public function showAction(Contract $contract)
    {
        $deleteForm = $this->createDeleteForm($contract);

        $mission = $this->get('missionManager')->getMissionByContract($contract);

        return $this->render('@Interim/contract/show.html.twig', array(
            'contract' => $contract,
            'delete_form' => $deleteForm->createView(),
            'mission'   => $mission
        ));
    }

    /**
     * Displays a form to edit an existing contract entity.
     *
     * @Route("/{id}/edit", name="contract_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Contract $contract)
    {
        $deleteForm = $this->createDeleteForm($contract);
        $editForm = $this->createForm('InterimBundle\Form\ContractType', $contract);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('contract_edit', array('id' => $contract->getId()));
        }

        return $this->render('@Interim/contract/edit.html.twig', array(
            'contract' => $contract,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a contract entity.
     *
     * @Route("/{id}", name="contract_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Contract $contract)
    {
        $form = $this->createDeleteForm($contract);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($contract);
            $em->flush();
        }

        return $this->redirectToRoute('contract_index');
    }

    /**
     * Creates a form to delete a contract entity.
     *
     * @param Contract $contract The contract entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Contract $contract)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('contract_delete', array('id' => $contract->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    /**
     *
     * @Route("/changeMission/{idmission}/{name}/{value}", name="change_attr_mission")
     *
     */
    private function changeAttrMissionAction(Contract $contract)
    {

        if ($request->isXmlHttpRequest()) {
            $mission = $em->getRepository('InterimBundle:MissionMonitor')->findOneById($request->request->get('idmission'));
            if($request->request->get('name') == "note") {
                $mission->setNote($request->request->get('value'));
            } else if ($request->request->get('name') == "status") {
                $mission->setStatus($request->request->get('value'));
            }
            return new JsonResponse( array('status'  => 'Success' ));
        }
        else {
            return new JsonResponse( array('status'  => 'Failure' ));
        }

    }
}
