<?php

namespace App\Controller\Admin;

use App\Entity\EventRequest;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class EventRequestController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return EventRequest::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Richiesta di evento')
            ->setEntityLabelInPlural('Richieste di eventi')
            ->setPageTitle(Crud::PAGE_INDEX, 'Richieste di eventi')
            ->setDefaultSort(['createdAt' => 'DESC'])
            ->setPaginatorPageSize(10);
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', 'Nome');
        yield EmailField::new('email', 'Email');
        yield TextField::new('phone', 'Telefono')->hideOnIndex();
        yield TextField::new('localita', 'Località')->hideOnIndex();

        // show eventDate using the string getter to avoid intl / DateTime->string issues
        yield TextField::new('eventDateString', 'Data evento')->onlyOnIndex();

        yield TextField::new('drinkService', 'Servizio bevande');
        yield TextField::new('eventType', 'Tipo di evento');
        yield TextField::new('meal', 'Pranzo/Cena')->hideOnIndex();
        yield IntegerField::new('people', 'Numero persone')->hideOnIndex();

        // start/end times shown as simple text
        yield TextField::new('startTime', 'Orario inizio')->hideOnIndex();
        yield TextField::new('endTime', 'Orario fine')->hideOnIndex();

        yield ArrayField::new('services', 'Servizi')->hideOnForm();
        yield TextareaField::new('message', 'Messaggio')->onlyOnDetail();

        // createdAt as plain string via getter (avoid intl)
        yield TextField::new('createdAtString', 'Inserita il')->onlyOnIndex();
    }
}