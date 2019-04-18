<?php
namespace AppBundle\Controller;
use AppBundle\Entity\Lesson;
use AppBundle\Entity\Person;
use AppBundle\Entity\Registration;
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

    /**
     * @Route("/lid/lessen",name="list_les_lid")
     */
    public function  showLidLessenListAction() {
        $repo = $this->getDoctrine()->getRepository(Lesson::class);
        $lesson = $repo->findAll();

        return $this->render('bezoeker/les/list.html.twig',[
            'lessen' => $lesson,
        ]);
    }

    /**
     * @Route("/lid/lessen/inschrijven/{id}",name="inschrijven_les_lid")
     */
    public function  inschrijvenLidLessenAction(Request $request, $id) {

        $flush = true;
        $les = $this->getDoctrine()->getRepository(Lesson::class)->find($id);
        $lidRepo = $this->getDoctrine()->getRepository(Person::class);//->findByUsername($this->getUser()->getUsername());
        $lidData = $lidRepo->findByUsername($this->getUser()->getUsername());
        $lid = $lidRepo->find($lidData[0]->getId());
        dump(gettype ($les));dump(gettype ($lid));dump($this->getUser()->getUsername());

        dump($les->getRegistrations());

        foreach ($les->getRegistrations() as $item) {
            dump($item->getMember()->getId());
            dump($lid);
            if($item->getMember()->getId() === $lid->getId() ){
                $flush = false;
            }
        }

        if($flush){
//            $registration = new Registration();
//            $registration->setLesson($les);
//            $registration->setMember($lid);
//            $registration->setPayment('pin');

            $payment = 'pinnen';
            $this->getDoctrine()->getRepository(Registration::class)->createRegistration($lid,$les, $payment);
            $this->addFlash('success','U bent ingeschreven');die;
            return $this->redirectToRoute('list_les_lid');

        }else{
            $this->addFlash('error','je hebt al ingeschreven');die;
            return $this->redirectToRoute('list_les_lid');
        }
    }









}