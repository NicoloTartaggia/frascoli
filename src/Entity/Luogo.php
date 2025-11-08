<?php

namespace App\Entity;

use App\Repository\LuogoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LuogoRepository::class)]
class Luogo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomeCard = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descrizioneCard = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $viaCard = null;

    #[ORM\Column(length: 512, nullable: true)]
    private ?string $imgCard = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(length: 512)]
    private ?string $nomeCover = null;

    #[ORM\Column(length: 512, nullable: true)]
    private ?string $imgCover = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descrizioneCover = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $metaTitle = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $metaDescription = null;

    #[ORM\Column(length: 512, nullable: true)]
    private ?string $menu = null;

    #[ORM\Column(length: 512, nullable: true)]
    private ?string $linkMaps = null;

    #[ORM\Column(length: 512, nullable: true)]
    private ?string $imgMappa = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $indirizzoFull = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $orariFull = null;

    #[ORM\Column(length: 512, nullable: true)]
    private ?string $urlInstagram = null;

    #[ORM\Column(length: 512, nullable: true)]
    private ?string $urlFacebook = null;

    #[ORM\Column(length: 512, nullable: true)]
    private ?string $urlRecensione = null;


    #[ORM\Column(length: 512, nullable: true)]
    private ?string $telefono = null;

    #[ORM\Column]
    private ?bool $attivo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(?string $telefono): void
    {
        $this->telefono = $telefono;
    }


    public function getNomeCard(): ?string
    {
        return $this->nomeCard;
    }

    public function setNomeCard(string $nomeCard): static
    {
        $this->nomeCard = $nomeCard;

        return $this;
    }

    public function getDescrizioneCard(): ?string
    {
        return $this->descrizioneCard;
    }

    public function setDescrizioneCard(?string $descrizioneCard): static
    {
        $this->descrizioneCard = $descrizioneCard;

        return $this;
    }

    public function getViaCard(): ?string
    {
        return $this->viaCard;
    }

    public function setViaCard(?string $viaCard): static
    {
        $this->viaCard = $viaCard;

        return $this;
    }

    public function getImgCard(): ?string
    {
        return $this->imgCard;
    }

    public function setImgCard(?string $imgCard): static
    {
        $this->imgCard = $imgCard;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getNomeCover(): ?string
    {
        return $this->nomeCover;
    }

    public function setNomeCover(string $nomeCover): static
    {
        $this->nomeCover = $nomeCover;

        return $this;
    }

    public function getImgCover(): ?string
    {
        return $this->imgCover;
    }

    public function setImgCover(?string $imgCover): static
    {
        $this->imgCover = $imgCover;

        return $this;
    }

    public function getDescrizioneCover(): ?string
    {
        return $this->descrizioneCover;
    }

    public function setDescrizioneCover(?string $descrizioneCover): static
    {
        $this->descrizioneCover = $descrizioneCover;

        return $this;
    }

    public function getMetaTitle(): ?string
    {
        return $this->metaTitle;
    }

    public function setMetaTitle(?string $metaTitle): static
    {
        $this->metaTitle = $metaTitle;

        return $this;
    }

    public function getMetaDescription(): ?string
    {
        return $this->metaDescription;
    }

    public function setMetaDescription(?string $metaDescription): static
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    public function getMenu(): ?string
    {
        return $this->menu;
    }

    public function setMenu(?string $menu): static
    {
        $this->menu = $menu;

        return $this;
    }

    public function getLinkMaps(): ?string
    {
        return $this->linkMaps;
    }

    public function setLinkMaps(?string $linkMaps): static
    {
        $this->linkMaps = $linkMaps;

        return $this;
    }

    public function getImgMappa(): ?string
    {
        return $this->imgMappa;
    }

    public function setImgMappa(?string $imgMappa): static
    {
        $this->imgMappa = $imgMappa;

        return $this;
    }

    public function getIndirizzoFull(): ?string
    {
        return $this->indirizzoFull;
    }

    public function setIndirizzoFull(?string $indirizzoFull): static
    {
        $this->indirizzoFull = $indirizzoFull;

        return $this;
    }

    public function getOrariFull(): ?string
    {
        return $this->orariFull;
    }

    public function setOrariFull(?string $orariFull): static
    {
        $this->orariFull = $orariFull;

        return $this;
    }

    public function getUrlInstagram(): ?string
    {
        return $this->urlInstagram;
    }

    public function setUrlInstagram(?string $urlInstagram): static
    {
        $this->urlInstagram = $urlInstagram;

        return $this;
    }

    public function getUrlFacebook(): ?string
    {
        return $this->urlFacebook;
    }

    public function setUrlFacebook(?string $urlFacebook): static
    {
        $this->urlFacebook = $urlFacebook;

        return $this;
    }

    public function getUrlRecensione(): ?string
    {
        return $this->urlRecensione;
    }

    public function setUrlRecensione(?string $urlRecensione): static
    {
        $this->urlRecensione = $urlRecensione;

        return $this;
    }

    public function isAttivo(): ?bool
    {
        return $this->attivo;
    }

    public function setAttivo(bool $attivo): static
    {
        $this->attivo = $attivo;

        return $this;
    }
}
