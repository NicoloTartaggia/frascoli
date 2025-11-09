<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingController extends AbstractController
{
    /**
     * @Route("/eventi", name="landing_booking", methods={"GET","POST"})
     */
    public function landing(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $data = [
                'name' => trim($request->request->get('name', '')),
                'email' => trim($request->request->get('email', '')),
                'phone' => trim($request->request->get('phone', '')),
                'localita' => trim($request->request->get('localita', '')),
                'date' => trim($request->request->get('date', '')),
                'event_type' => trim($request->request->get('event_type', '')),
                'message' => trim($request->request->get('message', '')),
            ];

            // handle conditional "Evento privato" fields
            if ($data['event_type'] === 'Evento privato') {
                $meal = trim($request->request->get('meal', ''));
                $people = trim($request->request->get('people', ''));
                $drink_service = trim($request->request->get('drink_service', ''));

                // validate people if provided
                if ($people !== '' && (!ctype_digit($people) || (int)$people < 1)) {
                    $this->addFlash('error', 'Il campo "Numero persone" deve contenere un intero positivo.');
                    return $this->redirectToRoute('landing_booking');
                }

                $data['meal'] = $meal;
                $data['people'] = $people === '' ? null : (int)$people;
                $data['drink_service'] = $drink_service;
            } else {
                // ensure private-only fields are not stored when another type is selected
                $data['meal'] = null;
                $data['people'] = null;
                $data['drink_service'] = null;
            }

            if (empty($data['name']) || empty($data['email'])) {
                $this->addFlash('error', 'Inserisci nome e email.');
                return $this->redirectToRoute('landing_booking');
            }

            // Placeholder persistence: store in session for now.
            $session = $request->getSession();
            $bookings = $session->get('landing_bookings', []);
            $bookings[] = $data;
            $session->set('landing_bookings', $bookings);

            // TODO: replace with real email/DB persistence
            $this->addFlash('success', 'Richiesta inviata. Ti risponderemo al più presto.');

            return $this->redirectToRoute('landing_booking');
        }

        return $this->render('app/landing_booking.html.twig');
    }
}