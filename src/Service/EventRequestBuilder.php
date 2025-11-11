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

        $er->setName(trim((string) $r->get('name', '')));
        $er->setEmail(trim((string) $r->get('email', '')));
        $er->setPhone(($p = trim((string) $r->get('phone', ''))) === '' ? null : $p);
        $er->setLocalita(($l = trim((string) $r->get('localita', ''))) === '' ? null : $l);

        $dateRaw = trim((string) $r->get('date', ''));
        if ($dateRaw !== '') {
            $d = \DateTime::createFromFormat('Y-m-d', $dateRaw);
            if ($d !== false) {
                $er->setEventDate($d);
            }
        }

        $drink = trim((string) $r->get('drink_service', ''));
        $er->setDrinkService($drink === '' ? 'Non richiesto' : $drink);

        $type = trim((string) $r->get('event_type', ''));
        $er->setEventType($type);

        // conditional fields
        if ($type === 'Evento privato') {
            $er->setMeal(($m = trim((string) $r->get('meal', ''))) === '' ? null : $m);
            $people = trim((string) $r->get('people', ''));
            $er->setPeople($people === '' ? null : (int)$people);
        } else {
            $er->setMeal(null);
            $er->setPeople(null);
        }

        if ($type === 'Evento a partecipazione libera' || $type === 'Evento aziendale') {
            $start = trim((string) $r->get('start_time', ''));
            $end = trim((string) $r->get('end_time', ''));
            $er->setStartTime($start === '' ? null : $start);
            $er->setEndTime($end === '' ? null : $end);
        } else {
            $er->setStartTime(null);
            $er->setEndTime(null);
        }

        if ($type === 'Evento aziendale') {
            $people = trim((string) $r->get('people', ''));
            $er->setPeople($people === '' ? null : (int)$people);
        }

        // --- SAFE: read raw params array to avoid InputBag::get scalar checks ---
        $params = $r->all();
        $rawServices = $params['services'] ?? null;

        $flat = [];
        $flatten = function ($v) use (&$flatten, &$flat) {
            if ($v === null) return;
            if (is_array($v)) {
                foreach ($v as $item) {
                    $flatten($item);
                }
                return;
            }
            if (is_scalar($v)) {
                $flat[] = (string) $v;
            }
        };
        $flatten($rawServices);

        $filtered = array_values(array_intersect($this->allowedServices, $flat));
        $er->setServices($filtered === [] ? null : $filtered);

        $er->setMessage(($msg = trim((string) $r->get('message', ''))) === '' ? null : $msg);

        return $er;
    }
}