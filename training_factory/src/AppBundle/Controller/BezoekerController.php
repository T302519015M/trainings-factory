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
     * @Route("/training/list", name="traininglist")
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
     * @Route("/training/new", name="addtraining")
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

    /**
     * @Route("training/update/{id}", name="update")
     */
    public function updateAction(Request $request, $id){

        $repo = $this->getDoctrine()->getRepository(Training::class);
        $trainingData = $repo->find($id);

        if(!$trainingData){
            throw $this->createNotFoundException(
                'Geen training gevonden voor deze ID:'.$id
            );
        }
        
        $form = $this->createForm(TrainingType::class, $trainingData);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $training = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($training);

            $em->flush();
            $this->addFlash('training-success', 'training bijgewerkt');
            return $this->redirectToRoute('traininglist');
        }

        return $this->render('bezoeker/training/update.html.twig', [
            'afdelingForm'=>$form->createView(),
            'trainingData'=>$trainingData
        ]);

    }

    /**
     * @Route("training/delete/{id}", name="delete")
     */
    public function removeAction(Request $request, $id){

        $repo = $this->getDoctrine()->getRepository(Training::class);
        $training = $repo->find($id);

        //dump($training);die;
        $em= $this->getDoctrine()->getManager();
        $em->remove($training);
        $em->flush();

        $this->addFlash('deleted-success','training verwijdered');
        return $this->redirectToRoute('traininglist');

//        $trainingen =$repo->findAll();
//
//        return $this->render('bezoeker/training/list.html.twig',['trainingen' => $trainingen]);
    }




}
