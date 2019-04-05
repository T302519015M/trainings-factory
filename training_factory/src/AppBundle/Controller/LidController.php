<?php
namespace AppBundle\Controller;
use AppBundle\Entity\Person;
use AppBundle\Entity\Training;
use AppBundle\Form\LidType;
use AppBundle\Form\TrainingType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;



class LidController extends Controller {

    /**
     * @Route("gegevens/{user}",name="update_self")
     */
    public function updateSelfAction(Request $request, $user){
        $repo = $this->getDoctrine()->getRepository(Person::class);
        $name = $user;

        if(($this->getUser()->getRoles())[0] !== 'ROLE_ADMIN'){
            $name = $this->getUser()->getUsername();
        }

        $target = $repo->findByUsername($name);
        $form = $this->createForm(LidType::class, $target[0]);
        $form->handleRequest($request);

        if($form->isValid() && $form->isSubmitted()){
            $repo->updatePerson($form->getData());
            $this->addFlash('success','gegevens zijn aangepast');
            return $this->redirectToRoute('homepage');
        }

        return $this->render('bezoeker/registratie.html.twig',[
           'user' => $user,
            'title' => 'mijn gegevens',
            'action'=> 'bijwerken',
            'form' => $form->createView(),
            'wachtwoord'=> $target[0]->getPassword()
        ]);

    }











}