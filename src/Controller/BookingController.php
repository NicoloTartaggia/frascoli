<?php

namespace App\Controller;

use App\Service\EventRequestBuilderInterface;
use App\Entity\EventRequest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class BookingController extends AbstractController
{
    /**
     * @Route("/eventi", name="landing_booking", methods={"GET","POST"})
     */
    public function landing(Request $request, EventRequestBuilderInterface $builder, EntityManagerInterface $em, MailerInterface $mailer): Response
    {
        if ($request->isMethod('POST')) {
            // build entity from request
            $eventRequest = $builder->buildFromRequest($request);

            // server-side validation (basic)
            if (trim($eventRequest->getName()) === '' || trim($eventRequest->getEmail()) === '') {
                $this->addFlash('error', 'Inserisci nome e email.');
                return $this->redirectToRoute('landing_booking');
            }

            // phone: require min 6 digits when provided
            if ($eventRequest->getPhone()) {
                $digits = preg_replace('/\D+/', '', $eventRequest->getPhone());
                if (strlen($digits) < 6) {
                    $this->addFlash('error', 'Telefono non valido.');
                    return $this->redirectToRoute('landing_booking');
                }
            }

            // event type required
            if (trim($eventRequest->getEventType()) === '') {
                $this->addFlash('error', 'Seleziona il tipo di evento.');
                return $this->redirectToRoute('landing_booking');
            }

            // per-event validations
            $type = $eventRequest->getEventType();
            if ($type === 'Evento privato') {
                if (!$eventRequest->getMeal() || !$eventRequest->getPeople()) {
                    $this->addFlash('error', 'Compila tutti i campi richiesti per Evento privato.');
                    return $this->redirectToRoute('landing_booking');
                }
            } elseif ($type === 'Evento a partecipazione libera') {
                if (!$eventRequest->getStartTime() || !$eventRequest->getEndTime()) {
                    $this->addFlash('error', 'Compila orario inizio/fine per Evento a partecipazione libera.');
                    return $this->redirectToRoute('landing_booking');
                }
            } elseif ($type === 'Evento aziendale') {
                if (!$eventRequest->getStartTime() || !$eventRequest->getEndTime() || !$eventRequest->getPeople()) {
                    $this->addFlash('error', 'Compila orario e numero persone per Evento aziendale.');
                    return $this->redirectToRoute('landing_booking');
                }
            }

            // persist
            $em->persist($eventRequest);
            $em->flush();

            // send email notification
            $email = (new Email())
                ->from('nicolo.tartaggia@gmail.com')
                ->to('nicolo.tartaggia@gmail.com')
                ->subject('Nuova richiesta di evento')
                ->html($this->renderView('emails/event_request_owner.html.twig', [
                    'request' => $eventRequest
                ]));

            $mailer->send($email);

            $this->addFlash('success', 'Richiesta salvata. Ti contatteremo a breve.');
            return $this->redirectToRoute('landing_booking');
        }

        return $this->render('app/landing_booking.html.twig');
    }
}