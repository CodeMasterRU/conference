<?php

namespace App\Controller;

use App\Entity\Events;
use App\Form\EventsType;
use App\Form\RechercheEventsType;
use App\Form\RechercheProduitType;
use App\Repository\EventsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    #[Route('/events', name: 'app_main')]
    public function index(EventsRepository $repo, Request $request): Response
    {
        $form = $this->createForm(RechercheEventsType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->get('recherche')->getData();
            $events = $repo->getEventsByName($data);
        } else {
            $events = $repo->findAllEvents();
        }

        return $this->render('main/index.html.twig', [
            'events' => $events,
            'recherche' => $form->createView(),
        ]);
    }
    #[Route('/events/show/{id}', name: 'app_show')]
    public function show(Events $events): Response
    {

       /* $comment->setProduit($this->$produit->getId());*/
        return $this->render('main/show.html.twig', [
            'events' => $events
        ]);
    }
    #[Route('/events/new', name: 'app_newEvents')]
    public function form(Request $request, EntityManagerInterface $manager, Events $events = null)
    {
        if ($this->isGranted('ROLE_ORGANISATEUR') == false) {
           return $this->redirectToRoute('app_main');
        }
        // if ($produit->setUser($this->getUser()) != $this->isGranted('user.id'))
        // {
        //     return $this->redirectToRoute('app_ecommerce');
        // }
        
        if (!$events) {
            $events = new Events;
            $events->setUser($this->getUser());
            $events->setUpdatedAt(new \DateTime());
        }

        $form = $this->createForm(EventsType::class, $events);
        $form->handleRequest($request);
        dump($events);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($events);
            $manager->flush();
            return $this->redirectToRoute('app_main', [
                'id' => $events->getId(),
            ]);
        }

        return $this->render('main/form.html.twig', [
            'formEvents' => $form->createView(),
        ]);
    }
}
