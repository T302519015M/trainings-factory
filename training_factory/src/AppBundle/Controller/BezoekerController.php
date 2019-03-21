<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Training;
use AppBundle\Form\TrainingType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BezoekerController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $repo = $this->getDoctrine()->getRepository(Training::class);
        $training = $repo->findAll();



        // replace this example code with whatever you need
        return $this->render('bezoeker/home.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'trainingen' => $training
        ]);
    }


    /**
     * @Route("/training/list", name="admin_afdeling_new")
     */
    public function showAction(Request $request)
    {
        $repo = $this->getDoctrine()->getRepository(Training::class);
        $trainingen = $repo->findAll();


        return $this->render('bezoeker/training/list.html.twig', [
            'trainingen'=> $trainingen
        ]);
    }

    /**
     * @Route("/training/new", name="admin_afdeling_new")
     */
    public function addAction(Request $request)
    {
        $form=$this->createForm(TrainingType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $training = $form->getData();
            //dump($form->getData());die;

            $em = $this->getDoctrine()->getManager();
            $em->persist($training);

            $em->flush();
            $this->addFlash('training-success', 'training toegevoegd');
            return $this->redirectToRoute('homepage');
        }

        return $this->render('bezoeker/training/new.html.twig', [
            'afdelingForm'=>$form->createView()
            ]);
    }
}
