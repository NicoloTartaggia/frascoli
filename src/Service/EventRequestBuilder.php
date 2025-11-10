<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;
use App\Entity\EventRequest;

class EventRequestBuilder implements EventRequestBuilderInterface
{
    private array $allowedServices = [
        'BIRRA ALLA SPINA',
        'DJ / IMPIANTO AUDIO',
        'SERVIZIO COCKTAIL',
        'SERVIZIO RIFIUTI',
        'DOLCE',
        'BOX FRITTI APERITIVO',
        'PANCHE E TAVOLI',
        'CAFFE',
    ];

    public function buildFromRequest(Request $request): EventRequest
    {
        $r = $request->request;
        $er = new EventRequest();

        $er->setName(trim($r->get('name', '')));
        $er->setEmail(trim($r->get('email', '')));
        $er->setPhone(($p = trim($r->get('phone', ''))) === '' ? null : $p);
        $er->setLocalita(($l = trim($r->get('localita', ''))) === '' ? null : $l);

        $dateRaw = trim($r->get('date', ''));
        if ($dateRaw !== '') {
            $d = \DateTime::createFromFormat('Y-m-d', $dateRaw);
            if ($d !== false) {
                $er->setEventDate($d);
            }
        }

        $drink = trim($r->get('drink_service', ''));
        $er->setDrinkService($drink === '' ? 'Non richiesto' : $drink);

        $type = trim($r->get('event_type', ''));
        $er->setEventType($type);

        // conditional fields
        if ($type === 'Evento privato') {
            $er->setMeal(($m = trim($r->get('meal', ''))) === '' ? null : $m);
            $people = trim($r->get('people', ''));
            $er->setPeople($people === '' ? null : (int)$people);
        } else {
            $er->setMeal(null);
            $er->setPeople(null);
        }

        if ($type === 'Evento a partecipazione libera' || $type === 'Evento aziendale') {
            $start = trim($r->get('start_time', ''));
            $end = trim($r->get('end_time', ''));
            $er->setStartTime($start === '' ? null : $start);
            $er->setEndTime($end === '' ? null : $end);
        } else {
            $er->setStartTime(null);
            $er->setEndTime(null);
        }

        if ($type === 'Evento aziendale') {
            $people = trim($r->get('people', ''));
            $er->setPeople($people === '' ? null : (int)$people);
        }

        $rawServices = $r->get('services');
        if ($rawServices === null) {
            $rawServices = [];
        } elseif (!is_array($rawServices)) {
            $rawServices = [$rawServices];
        }
        $filtered = array_values(array_intersect($this->allowedServices, $rawServices));
        $er->setServices($filtered === [] ? null : $filtered);

        $er->setMessage(($msg = trim($r->get('message', ''))) === '' ? null : $msg);

        return $er;
    }
}