<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Lesson;
use AppBundle\Entity\Person;
use AppBundle\Entity\Training;
use AppBundle\Form\LidType;
use AppBundle\Form\TrainingType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class BezoekerController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    //homepage
    public function indexAction(Request $request)
    {
        $repo = $this->getDoctrine()->getRepository(Training::class);
        $training = $repo->findAll();
        $user = $this->getUser();

        return $this->render('bezoeker/home.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'trainingen' => $training,
            'user'=> $user
        ]);
    }

    /**
     * @Route("/registratie", name="registratie")
     */
    public function registrationAction(Request $request){

        $user = $this->getUser();
        $form = $this->createForm(LidType::class);
        $form->handleRequest($request);

        if($form->get('passCheck')->getData() === $form->get('password')->getData()){
            $passwordMatch = true;
        }else{
            $passwordMatch = false;
        }

        if( $form->isSubmitted() && $form->isValid()){
            $form->getData()->setRole(['ROLE_MEMBER']);

            $this->getDoctrine()
                ->getRepository(Person::class)
                ->createPerson($form->getData());

            $this->addFlash('success','registratie gelukt');
            return $this->redirectToRoute('homepage');
        }

        return $this->render('bezoeker/registratie.html.twig', [
            'title'=> 'Registratie',
            'action'=>'registeren',
            'user'=> $user,
            'form'=> $form->createView(),
            'passwordMatch' => $passwordMatch,
            'wachtwoord' => null
            ]);
    }

//    /**
//     * @Route("/training/list", name="traininglist")
//     */
//    //toon lijst met training
//    public function showAction(Request $request)
//    {
//        $repo = $this->getDoctrine()->getRepository(Training::class);
//        $trainingen = $repo->findAll();
//        $user = $this->getUser();
//
//
//        return $this->render('bezoeker/training/list.html.twig', [
//            'trainingen'=> $trainingen,
//            'user'=> $user
//        ]);
//    }
//
//    /**
//     * @Route("/training/new", name="addtraining")
//     */
//    //
//    public function addAction(Request $request)
//    {
//        $form=$this->createForm(TrainingType::class);
//
//        $form->handleRequest($request);
//
//        if($form->isSubmitted() && $form->isValid()){
//
//            $this->getDoctrine()
//                ->getRepository(Training::class)
//                ->createTraining($form->getData());
//
//            $this->addFlash('success', 'training toegevoegd');
//            return $this->redirectToRoute('homepage');
//        }
//
//        return $this->render('bezoeker/training/new.html.twig', [
//            'afdelingForm'=>$form->createView()
//        ]);
//    }
//
//    /**
//     * @Route("training/update/{id}", name="update")
//     */
//    public function updateAction(Request $request, $id){
//
//        $trainingRepo = $this->getDoctrine()->getRepository(Training::class);
//        $trainingData = $trainingRepo->findTraining($id);
//
//        if(!$trainingData){
//            $this->addFlash('error', 'Geen training gevonden voor deze ID');
//            return $this->redirectToRoute('traininglist');
//        }
//
//        $form = $this->createForm(TrainingType::class, $trainingData);
//        $form->handleRequest($request);
//
//        if($form->isSubmitted() && $form->isValid()){
//            $trainingRepo->updateTraining($form->getData());
//            $this->addFlash('success', 'training bijgewerkt');
//            return $this->redirectToRoute('traininglist');
//        }
//
//        return $this->render('bezoeker/training/update.html.twig', [
//            'afdelingForm'=>$form->createView(),
//            'trainingData'=>$trainingData
//        ]);
//
//    }
//
//    /**
//     * @Route("training/delete/{id}", name="delete")
//     */
//    public function removeAction(Request $request, $id){
//
//        $trainingRepo = $this->getDoctrine()->getRepository(Training::class);
//        $trainingData = $trainingRepo->findTraining($id);
//
//        if($trainingData){
//            $this->addFlash('error','geen training gevonden met deze ID, verwijderen mislukt');
//            return $this->redirectToRoute('traininglist');
//        }
//
//        $trainingRepo->deleteTraining($id);
//        $this->addFlash('success','training verwijdered');
//        return $this->redirectToRoute('traininglist');
//
////        $trainingen =$repo->findAll();
////
////        return $this->render('bezoeker/training/list.html.twig',['trainingen' => $trainingen]);
//    }






//    /**
//     * @Route("/login", name="login")
//     */
//    public function loginAction(AuthenticationUtils $authenticationUtils)
//    {
//        // get the login error if there is one
//        $error = $authenticationUtils->getLastAuthenticationError();
//
//        // last username entered by the user
//        $lastUsername = $authenticationUtils->getLastUsername();
//
//        return $this->render('bezoeker/login.html.twig', [
//            'last_username' => $lastUsername,
//            'error'         => $error,
//        ]);
//    }

}
