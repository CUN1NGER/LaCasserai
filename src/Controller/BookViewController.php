<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BookViewController extends AbstractController
{
    /**
     * @Route("/admin/bookview", name="book_view")
     */
    public function index()
    {
        $current_date = new \DateTime();

        $em = $this->getDoctrine()->getManager();
        $booking = $em->getRepository('App:Booking')->findBy(['checkinDate' => $current_date]);
        $yeet = $em->getRepository('App:Booking')->findBy(['checkoutDate' => $current_date]);

        return $this->render('bookview/index.html.twig', [
            'booking' => $booking,
            'yeet' => $yeet,
            'controller_name' => 'BookViewController',
        ]);
    }
}