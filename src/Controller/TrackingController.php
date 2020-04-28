<?php

namespace App\Controller;

use App\Entity\Tracking;
use App\Form\TrackingType;
use App\Repository\TrackingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tracking")
 * @IsGranted("ROLE_COLLABORATOR")
 */
class TrackingController extends AbstractController
{
    private $trackings;

    public function __construct(TrackingRepository $trackingRepo)
    {
        $this->trackings = $trackingRepo->findAll();
    }

    /**
     * @Route("/", name="tracking_index", methods={"GET"})
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('tracking/index.html.twig', [
            'trackings' => $this->trackings,
        ]);
    }

    /**
     * @Route("/new", name="tracking_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $tracking = new Tracking();
        $form = $this->createForm(TrackingType::class, $tracking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tracking);
            $entityManager->flush();

            return $this->redirectToRoute('tracking_index');
        }

        return $this->render('tracking/new.html.twig', [
            'tracking' => $tracking,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_COLLABORATOR")
     * @Route("/show/{id}", name="tracking_show", methods={"GET","POST"})
     * @param Tracking $tracking

     * @param Request $request

     * @return Response
     */
    public function show(Tracking $tracking,
                         Request $request
    ): Response
    {

        return $this->render('tracking/show.html.twig', [
            'id' => $tracking->getId(),
            'tracking' => $tracking,
            'trackings' =>$this->trackings,
        ]);

}
    /*  ($form['isReceived']->getData() === "1") {
            $tracking->setIsReceived($isReceived);
            }else {
            $tracking->setIsReceived(0);
        }
             */
    /**
     * @Route("/{id}/edit", name="tracking_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Tracking $tracking
     * @return Response
     */
    public function edit(Request $request, Tracking $tracking): Response
    {
        $id = $tracking->getId();
        $form = $this->createForm(TrackingType::class, $tracking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tracking =$tracking->getImei();

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tracking_index');
        }

        return $this->render('tracking/edit.html.twig', [
            'tracking' => $tracking,
            'id'=>$id,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tracking_delete", methods={"DELETE"})
     * @param Request $request
     * @param Tracking $tracking
     * @return Response
     */
    public function delete(Request $request, Tracking $tracking): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tracking->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tracking);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tracking_index');
    }

    /*
       /**
        * @Route("/isReceived", name="isReceived")
        * @param TrackingRepository $trackingRepository
        * @param Tracking $tracking
        * @param Request $request
        */
    /* public function isReceived(TrackingRepository $trackingRepository, Tracking $tracking,
                                )
     {

         //$tracking = $trackingRepository->findByIsReceived();


        // $queryBuilder = $em->getRepository(Tracking::class)->findAll();
       //  $isReceived = [];



     }
     */
}
