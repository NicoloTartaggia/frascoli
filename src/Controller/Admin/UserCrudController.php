<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID')
                ->hideOnForm(),
            ImageField::new('img_profilo', 'Profilo')
                ->hideOnIndex()
                ->setBasePath('/uploads/profili/')
                ->setUploadDir('/public/uploads/profili/')
                ->setUploadedFileNamePattern('[uuid]-[slug].[extension]'),
            TextField::new('nome'),
            TextField::new('cognome'),
            TextField::new('email'),
            ArrayField::new('roles','Ruoli')
                ->setPermission('ROLE_SUPERADMIN'),
        ];
    }

    public function configureCrud(Crud $crud): Crud {
        return $crud
            ->setEntityLabelInSingular('Utente')
            ->setEntityLabelInPlural('Utenti')

            ->setPageTitle('index', 'Elenco %entity_label_plural%')
            ->setDefaultSort(['id' => 'ASC'])
            ->setPaginatorPageSize(50)
            ;


    }

    public function configureActions(Actions $actions): Actions
    {
        $impersonate = Action::new('impersonate', 'Impersona')
            //changed from linkToRoute to linkToUrl. note that linkToUrl has only one parameter.
            //"admin/.. can be adjusted to another URL"
            ->linkToUrl(function (User $entity) {
                return 'admin/?_switch_user='.$entity->getEmail();
            })
        ;


        return $actions
            ->add(Action::NEW, Action::DELETE)
                ->setPermission(Action::NEW, 'ROLE_SUPERADMIN')
            ->setPermission(Action::DELETE, 'ROLE_SUPERADMIN')
            ->add(Crud::PAGE_INDEX, $impersonate)
            ->setPermission($impersonate, 'ROLE_SUPERADMIN')
            ->remove(Crud::PAGE_INDEX, Action::EDIT)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ;
    }
}
