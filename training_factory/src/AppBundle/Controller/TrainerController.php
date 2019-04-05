<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Lesson;
use AppBundle\Entity\Person;
use AppBundle\Form\LesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TrainerController extends controller
{

    /**
     * @Route("/lessen/list", name="list_les")
     */
    // toont alle lessen
    public function showLesAction(Request $request){
        $repo = $this->getDoctrine()->getRepository(Lesson::class);
        $lessen = $repo->findAll();

        return $this->render("trainer/lessen/list.html.twig",[
            'lessen'=> $lessen,
        ]);
    }

    /**
     * @Route("/lessen/new",name="add_les")
     */
    // lessen toevoegen
    public function addLesAction(Request $request){
        $form = $this->createForm(LesType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $this->getDoctrine()->getRepository(Lesson::class)->createLesson($form->getData());
            $this->addFlash('success', 'les toegevoegd');
            return $this->redirectToRoute('list_les');
        }

         return $this->render("trainer/lessen/lessenCRUD.html.twig",[
            'action'=> 'voeg les toe',
            'title'=> 'Les toevoegen',
            'lessenForm' => $form->createView()
         ]);
    }

    /**
     * @Route("/lessen/update/{id}",name="update_les")
     */
    // lessen wijzigen
    public function updateLesAction(Request $request, $id){
        $repo = $this->getDoctrine()->getRepository(Lesson::class);
        $les = $repo->find($id);
        $form = $this->createForm(LesType::class,$les);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $repo->updateLesson($form->getData());
            $this->addFlash('success', 'les gewijzigd');
            return $this->redirectToRoute('list_les');
        }

        return $this->render("trainer/lessen/lessenCRUD.html.twig",[
            'action'=> 'les updaten',
            'title'=> 'LesType wijzigen',
            'lessenForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/lessen/delete/{id}",name="delete_les")
     */
    //lessen verwijderen
    public function deleteLesAction(Request $request, $id){
        $repo = $this->getDoctrine()->getRepository(Lesson::class);
        $les = $repo->find($id);
        $lessen = $repo->findAll();

        if($les){
           $repo->deleteLesson($les);
           $this->addFlash('success', 'les verwijdererd');
           return $this->redirectToRoute('list_les');
        }

        return $this->render("trainer/lessen/list.html.twig",[
            'lessen'=> $lessen,
        ]);
    }
}