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

            // always read drink_service as basic input; default to "Non richiesto" if empty
            $drinkService = trim($request->request->get('drink_service', ''));
            $data['drink_service'] = $drinkService === '' ? 'Non richiesto' : $drinkService;

            // read additional services (checkboxes)
            $rawServices = $request->request->get('services');
            if ($rawServices === null) {
                $rawServices = [];
            } elseif (!is_array($rawServices)) {
                $rawServices = [$rawServices];
            }
            $allowedServices = [
                'BIRRA ALLA SPINA',
                'DJ / IMPIANTO AUDIO',
                'SERVIZIO COCKTAIL',
                'SERVIZIO RIFIUTI',
                'DOLCE',
                'BOX FRITTI APERITIVO',
                'PANCHE E TAVOLI',
                'CAFFE',
            ];
            $data['services'] = array_values(array_intersect($allowedServices, $rawServices));

            // basic validation: required fields
            if (empty($data['name']) || empty($data['email'])) {
                $this->addFlash('error', 'Inserisci nome e email.');
                return $this->redirectToRoute('landing_booking');
            }

            // phone validation (optional but if provided must match)
            if ($data['phone'] !== '') {
                // allow digits, spaces, +, -, parentheses; require at least 6 digits
                $digitsOnly = preg_replace('/\D+/', '', $data['phone']);
                if (strlen($digitsOnly) < 6) {
                    $this->addFlash('error', 'Telefono non valido. Inserire un numero di telefono corretto.');
                    return $this->redirectToRoute('landing_booking');
                }
            }

            // event type required
            if ($data['event_type'] === '') {
                $this->addFlash('error', 'Seleziona il tipo di evento.');
                return $this->redirectToRoute('landing_booking');
            }

            // helper to validate time strings and compare
            $isValidTime = function ($t) {
                return $t !== null && $t !== '' && preg_match('/^\d{2}:\d{2}$/', $t);
            };
            $toMinutes = function ($t) {
                [$hh, $mm] = explode(':', $t);
                return ((int)$hh) * 60 + ((int)$mm);
            };

            // conditional handling + validation per event type
            if ($data['event_type'] === 'Evento privato') {
                $meal = trim($request->request->get('meal', ''));
                $people = trim($request->request->get('people', ''));

                if ($meal === '') {
                    $this->addFlash('error', 'Seleziona Pranzo o Cena per Evento privato.');
                    return $this->redirectToRoute('landing_booking');
                }
                if ($people === '' || !ctype_digit($people) || (int)$people < 1) {
                    $this->addFlash('error', 'Il campo "Numero persone" deve contenere un intero positivo per Evento privato.');
                    return $this->redirectToRoute('landing_booking');
                }

                $data['meal'] = $meal;
                $data['people'] = (int)$people;

                $data['start_time'] = null;
                $data['end_time'] = null;
            } elseif ($data['event_type'] === 'Evento a partecipazione libera') {
                $start = trim($request->request->get('start_time', ''));
                $end = trim($request->request->get('end_time', ''));

                if (!$isValidTime($start) || !$isValidTime($end)) {
                    $this->addFlash('error', 'Seleziona orario di inizio e fine validi per Evento a partecipazione libera.');
                    return $this->redirectToRoute('landing_booking');
                }
                if ($toMinutes($start) > $toMinutes($end)) {
                    $this->addFlash('error', 'L\'orario di inizio deve essere precedente o uguale all\'orario di fine.');
                    return $this->redirectToRoute('landing_booking');
                }

                $data['start_time'] = $start;
                $data['end_time'] = $end;

                $data['meal'] = null;
                $data['people'] = null;
            } elseif ($data['event_type'] === 'Evento aziendale') {
                $start = trim($request->request->get('start_time', ''));
                $end = trim($request->request->get('end_time', ''));
                $people = trim($request->request->get('people', ''));

                if (!$isValidTime($start) || !$isValidTime($end)) {
                    $this->addFlash('error', 'Seleziona orario di inizio e fine validi per Evento aziendale.');
                    return $this->redirectToRoute('landing_booking');
                }
                if ($toMinutes($start) > $toMinutes($end)) {
                    $this->addFlash('error', 'L\'orario di inizio deve essere precedente o uguale all\'orario di fine.');
                    return $this->redirectToRoute('landing_booking');
                }
                if ($people === '' || !ctype_digit($people) || (int)$people < 1) {
                    $this->addFlash('error', 'Il campo "Numero di persone" deve contenere un intero positivo per Evento aziendale.');
                    return $this->redirectToRoute('landing_booking');
                }

                $data['start_time'] = $start;
                $data['end_time'] = $end;
                $data['people'] = (int)$people;
                $data['meal'] = null;
            } else {
                // unknown/other -> clear conditional fields
                $data['meal'] = null;
                $data['people'] = null;
                $data['start_time'] = null;
                $data['end_time'] = null;
            }

            // Placeholder persistence: store in session for now.
            $session = $request->getSession();
            $bookings = $session->get('landing_bookings', []);
            $bookings[] = $data;
            $session->set('landing_bookings', $bookings);

            $this->addFlash('success', 'Richiesta inviata. Ti risponderemo al più presto.');

            return $this->redirectToRoute('landing_booking');
        }

        return $this->render('app/landing_booking.html.twig');
    }
}