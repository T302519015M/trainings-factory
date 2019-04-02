<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Person;
use AppBundle\Entity\Training;
use AppBundle\Form\TrainerType;
use AppBundle\Form\TrainingType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends Controller
{
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
            $this->addFlash('success', 'training toegevoegd');
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

            $this->addFlash('error', 'voor deze ID is geen training gevonden, updaten mislukt');
            return $this->redirectToRoute('traininglist');

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
            $this->addFlash('success', 'training bijgewerkt');
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

        if(!$training){

            $this->addFlash('error', 'voor deze ID is geen training gevonden, verwijderen mislukt');
            return $this->redirectToRoute('traininglist');

            throw $this->createNotFoundException(
                'Geen training gevonden voor deze ID:'.$id
            );
        }

        //dump($training);die;
        $em= $this->getDoctrine()->getManager();
        $em->remove($training);
        $em->flush();

        $this->addFlash('success','training verwijdered');
        return $this->redirectToRoute('traininglist');

    }

    /**
     * @Route("/trainer/list", name="list_trainer")
     */
    public function showTrainerAction(Request $request){
        $repo = $this->getDoctrine()->getRepository(Person::class);
        $persons = $repo->findAll();

        $user = $this->getUser();

        //convert back to string
        foreach ( $persons as $person) {
            $role = $person->getRole();
            $person->setRole($role[0]);
        }

        //filter array to find trainers
        $trainers = array_filter($persons,function($person){
            return ($person->getRole() == 'ROLE_TRAINER');
        });

        return $this->render('admin/trainer/list.html.twig',[
            'persons'=> $trainers,
            'user'=> $user
        ]);
    }

    /**
     * @Route("/trainer/new",name="add_trainer")
     */
    public function addTrainerAction(Request $request){
        $user = $this->getUser();
        $form = $this->createForm(TrainerType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $trainer = $form->getData();
            $role = $trainer->getRole();
            $trainer->setRole([$role]);
            //dump($trainer);die;

            $em = $this->getDoctrine()->getManager();
            $em->persist($trainer);
            $em->flush();
            $this->addFlash('success', 'trainer toegevoegd');
            return $this->redirectToRoute('homepage');
        }

        return $this->render('admin/trainer/trainerCRUD.html.twig',[
            'trainerForm' => $form->createView(),
            'title'=> 'nieuwe trainer toevoegen',
            'action'=> 'voeg trainer toe',
            'user'=> $user
        ]);
    }

    /**
     * @Route("trainer/update/{id}", name="update_trainer")
     */
    public function updateTrainerAction(Request $request, $id){

        $repo = $this->getDoctrine()->getRepository(Person::class);
        $trainerData = $repo->find($id);

        if(!$trainerData){

            $this->addFlash('error', 'voor deze ID is geen trainer gevonden, geen wijzigingen mogelijk');
            return $this->redirectToRoute('list_trainer');

            throw $this->createNotFoundException(
                'Geen trainer gevonden met deze ID:'.$id
            );
        }

        $role = $trainerData->getRole();
        $trainerData->setRole($role[0]);


        $form = $this->createForm(TrainerType::class, $trainerData);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $trainer = $form->getData();
            $role = $trainer->getRole();
            $trainer->setRole([$role]);

            $em = $this->getDoctrine()->getManager();
            $em->persist($trainer);

            $em->flush();
            $this->addFlash('success', '$trainer bijgewerkt');
            return $this->redirectToRoute('list_trainer');
        }

        return $this->render('admin/trainer/trainerCRUD.html.twig', [
            'trainerForm'=>$form->createView(),
            'trainerData'=>$trainerData,
            'title'=> 'trainer gegevens wijzigen',
            'action'=> 'update gegevens'
        ]);

    }

    /**
     * @Route("trainer/delete/{id}", name="delete_trainer")
     */
    public function deleteTrainerAction(Request $request, $id){

        $repo = $this->getDoctrine()->getRepository(Person::class);
        $person = $repo->find($id);


        if(!$person){
            $this->addFlash('error', 'voor deze ID is geen trainer gevonden, verwijderen mislukt');
            return $this->redirectToRoute('list_trainer');

            throw $this->createNotFoundException(
                'Geen trainer gevonden met deze ID:'.$id
            );
        }

        $em= $this->getDoctrine()->getManager();
        $em->remove($person);
        $em->flush();

        $this->addFlash('success','trainer verwijdered');
        return $this->redirectToRoute('list-trainer');

    }
}
