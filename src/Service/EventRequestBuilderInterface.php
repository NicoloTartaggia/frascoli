<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;
use App\Entity\EventRequest;

interface EventRequestBuilderInterface
{
    public function buildFromRequest(Request $request): EventRequest;
}