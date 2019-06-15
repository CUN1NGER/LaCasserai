<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Booking;
use App\Form\BookRoomType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $room = $em->getRepository('App:Room')->findAll();

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'room' => $room
        ]);
    }

    /**
     * @Route("/view/{slug}", name="view")
     */
    public function view($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $room = $em->getRepository('App:Room')->findBy(array("id" => $slug));
        $room_id = $em->getRepository('App:Room')->find($slug);

        $book_room = new Booking();
        $form = $this->createForm(BookRoomType::class, $book_room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user_id = $this->getUser()->getId();
            $user = $em->getRepository('App:User')->find($user_id);
            $book_room->setUser($user);
            $book_room->setRoom($room_id);
            $room_id->setAvailability(0);

            $em->persist($book_room);
            $em->flush();

            return $this->redirectToRoute('default');
        }

        return $this->render('default/view.html.twig', [
            'controller_name' => 'DefaultController',
            'room' => $room,
            'form' => $form->createView()
        ]);
    }
}
