<?php

namespace App\Controller\Admin;

use App\Admin\Field\CKEditorField;
use App\Entity\Luogo;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;

class LuogoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Luogo::class;
    }

    public function configureCrud(Crud $crud): Crud {
        return $crud
            ->setEntityLabelInSingular('Luogo')
            ->setEntityLabelInPlural('Luoghi')
            ->setFormThemes(['@FOSCKEditor/Form/ckeditor_widget.html.twig', '@EasyAdmin/crud/form_theme.html.twig'])
            ->setPageTitle('index', 'Elenco %entity_label_plural%')
            //->setDefaultSort(['ordinamento' => 'ASC'])
            ->setPaginatorPageSize(50)
            ;


    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnIndex()
                ->hideWhenUpdating()
                ->hideWhenCreating(),
            FormField::addFieldset('Informazioni locale'),
            TextField::new('nomeCover', 'Nome'),
            SlugField::new('slug')
                ->setTargetFieldName('nomeCover'),
            TextareaField::new('descrizioneCover', 'Descrizione')
                ->setHelp('Descrizione cover')
                ->hideOnIndex(),
            ImageField::new('imgCover','Immagine copertina')
                ->setHelp('Visibile sulla copertina. <br> Massimo 2MB. Formati supportati jpeg, png, webp')
                ->setBasePath('/uploads/luogo/')
                ->setUploadDir('/public/uploads/luogo/')
                ->setUploadedFileNamePattern('cover-[slug].[extension]')
                ->hideOnIndex(),
            TextField::new('menu', 'File del Menù')
                ->setFormType( FileUploadType::class )
                ->setHelp('Massimo 15MB. Caricare in formato PDF')
                ->hideOnIndex()
                ->setCustomOption('basePath', '/uploads/menu/')
                ->setFormTypeOptions(['upload_dir' => '/public/uploads/menu/'])
                ->setCustomOption('uploadedFileNamePattern', '[year]-[month]-[day]-[slug].[extension]'),

            BooleanField::new('attivo', 'Attivo')
                ->setHelp('Attiva o disattiva il luogo')
                ->hideOnIndex(),

            FormField::addFieldset('Contatti'),
            TextEditorField::new('indirizzoFull', 'Indirizzo')
                //->renderAsHtml()
                ->hideOnIndex(),
            TextEditorField::new('orariFull', 'Orari')
                //->renderAsHtml()
                ->hideOnIndex(),
            TextField::new('telefono', 'Telefono'),
            ImageField::new('imgMappa', 'Immagine mappa')
                ->setHelp('Massimo 2MB. Formati supportati jpeg, png, webp')
                ->setBasePath('/uploads/luogo/')
                ->setUploadDir('/public/uploads/luogo/')
                ->setUploadedFileNamePattern('mappa-[slug].[extension]')
                ->hideOnIndex(),

            FormField::addFieldset('SEO'),
            TextField::new('metaTitle', 'Titolo SEO')
                ->hideOnIndex(),
            TextareaField::new('metaDescription', 'Descrizione SEO')
                ->hideOnIndex(),


            FormField::addFieldset('Card homepage'),
            TextField::new('nomeCard', 'Nome')
                ->hideOnIndex(),
            TextField::new('viaCard', 'Indirizzo breve'),
            TextareaField::new('descrizioneCard', 'Descrizione')
                ->setHelp('Descrizione breve')
                ->hideOnIndex(),
            ImageField::new('imgCard','Immagine')
                ->setHelp('Visibile in home. <br> Massimo 2MB. Formati supportati jpeg, png, webp')
                ->setBasePath('/uploads/luogo/')
                ->setUploadDir('/public/uploads/luogo/')
                ->setUploadedFileNamePattern('card-[slug].[extension]')
                ->hideOnIndex(),

            FormField::addFieldset('Links'),
            UrlField::new('linkMaps', 'Link google Maps')
                ->hideOnIndex(),
            UrlField::new('urlInstagram', 'Link Instagram')
                ->hideOnIndex(),
            UrlField::new('urlFacebook', 'Link Facebook')
                ->hideOnIndex(),
            UrlField::new('urlRecensione', 'Link per recensione')
                ->hideOnIndex(),



        ];
    }

}
