<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Lesson;
use AppBundle\Form\Les;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TrainerController extends controller
{

    /**
     * @Route("/lessen/list", name="list_les")
     */
    public function showLesAction(Request $request){
        $user = $this->getUser();
        $repo = $this->getDoctrine()->getRepository(Lesson::class);
        $lessen = $repo->findAll();

        return $this->render("trainer/lessen/list.html.twig",[
            'lessen'=> $lessen,
            'user'=>$user,
        ]);

    }


    /**
     * @Route("/lessen/new",name="add_les")
     */
    public function addLesAction(Request $request){
        $user = $this->getUser();
        $form = $this->createForm(Les::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $les = $form->getData();
            //dump($les);die;
            $em = $this->getDoctrine()->getManager();
            $em->persist($les);
            $em->flush();

            $this->addFlash('success', 'les toegevoegd');
            return $this->redirectToRoute('list_les');
        }

         return $this->render("trainer/lessen/lessenCRUD.html.twig",[
            'action'=> 'voeg les toe',
            'title'=> 'Les toevoegen',
            'user'=> $user,
            'lessenForm' => $form->createView()
         ]);
    }

    /**
     * @Route("/lessen/update/{id}",name="update_les")
     */
    public function updateLesAction(Request $request, $id){
        $user = $this->getUser();
        $repo = $this->getDoctrine()->getRepository(Lesson::class);
        $les = $repo->find($id);
        $form = $this->createForm(Les::class,$les);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $les = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($les);
            $em->flush();

            $this->addFlash('success', 'les gewijzigd');
            return $this->redirectToRoute('list_les');
        }

        return $this->render("trainer/lessen/lessenCRUD.html.twig",[
            'action'=> 'les updaten',
            'title'=> 'Les wijzigen',
            'user'=> $user,
            'lessenForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/lessen/delete/{id}",name="delete_les")
     */
    public function deleteLesAction(Request $request, $id){
        $user = $this->getUser();
        $repo = $this->getDoctrine()->getRepository(Lesson::class);
        $les = $repo->find($id);
        $lessen = $repo->findAll();

        if($les){
           $em = $this->getDoctrine()->getManager();
           $em->remove($les);
           $em->flush();

           $this->addFlash('success', 'les verwijdererd');
           return $this->redirectToRoute('list_les');
        }

        return $this->render("trainer/lessen/list.html.twig",[
            'user'=> $user,
            'lessen'=> $lessen,
        ]);
    }
}