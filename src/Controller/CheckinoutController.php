<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
class CheckinoutController extends AbstractController
{
    /**
     * @Route("/admin/checkinout", name="checkinout")
     */
    public function index()
    {
        $current_date = new \DateTime();
        $em = $this->getDoctrine()->getManager();
        $booking = $em->getRepository('App:Booking')->findBy(['checkinDate' => $current_date]);
        $booking2 = $em->getRepository('App:Booking')->findBy(['checkoutDate' => $current_date]);
        return $this->render('checkinout/index.html.twig', [
            'booking' => $booking,
            'booking2' => $booking2,
            'controller_name' => 'CheckinoutController',
        ]);
    }
}