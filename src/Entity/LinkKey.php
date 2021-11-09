<?php

namespace App\Entity;

use App\Repository\LinkKeyRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Validator as LinkKeyAssert;
use App\Validator as DateNotExpireAssert;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=LinkKeyRepository::class)
 */
class LinkKey
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @LinkKeyAssert\UrlIsExist
     */

    private $url_name;

    /**
     * @ORM\Column(type="datetime")
     * @LinkKeyAssert\DateNotExpire
     */
    private $time_exp;

    /**
     * @ORM\Column(type="text")
     */
    private $short_link;

    /**
     * @ORM\Column(type="bigint", nullable=false, options={"default" = 0})
     */
    private $num_click;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrlName(): ?string
    {
        return $this->url_name;
    }

    public function setUrlName(string $urlName): self
    {
        $this->url_name = $urlName;

        return $this;
    }

    public function getTimeExp(): ?\DateTimeInterface
    {
        return $this->time_exp;
    }

    public function setTimeExp(\DateTimeInterface $time_exp): self
    {
        $this->time_exp = $time_exp;

        return $this;
    }

    public function getShortLink(): ?string
    {
        return $this->short_link;
    }

    public function setShortLink(string $short_link): self
    {
        $this->short_link = $short_link;

        return $this;
    }

    public function getNumClick(): ?string
    {
        return $this->num_click;
    }

    public function setNumClick(?string $num_click): self
    {
        $this->num_click = $num_click;

        return $this;
    }


}
