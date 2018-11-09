<?php

namespace AppBundle\Entity\Crowding;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation as JMS;

/**
 * Translation
 *
 * @ORM\Table(name="translation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Crowding\TranslationRepository")
 * @UniqueEntity(
 *     fields={"domain", "code"},
 *     message="Code existe for this domain."
 * )
 * @JMS\ExclusionPolicy("all")
 */
class Translation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Groups({"DETAIL"})
     * @JMS\Expose 
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255)
     * @JMS\Groups({"DETAIL"})
     * @JMS\Expose 
     */
    private $code;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Crowding\Domain", fetch="EAGER", inversedBy="translations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $domain;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Crowding\TranslationToLang", mappedBy="translation", cascade={"persist"})
     */
    private $translationToLang;

    public function getTransByLang($code) {
        foreach ($this->translationToLang as $lang) {
            if ($lang->getLang()->getCode() === $code)
                return $lang;
        }
        return false;
    }

    /**
     * @JMS\VirtualProperty()
     * @JMS\Groups({"DETAIL"})
     * @JMS\SerializedName("trans")
     */
    public function getVirtualLangs()
    {
        $res = [];
        foreach ($this->getTranslationToLang() as $ttl) {
            $res[$ttl->getLang()->getCode()] = $ttl->getTrans();
        }
        foreach ($this->getDomain()->getLangs() as $lang) {
            if (!isset($res[$lang->getCode()]))
                $res[$lang->getCode()] = $this->code;
        }
        return $res;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Translation
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set domain
     *
     * @param \AppBundle\Entity\Crowding\Domain $domain
     *
     * @return Translation
     */
    public function setDomain(\AppBundle\Entity\Crowding\Domain $domain)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Get domain
     *
     * @return \AppBundle\Entity\Crowding\Domain
     */
    public function getDomain()
    {
        return $this->domain;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->translationToLang = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add translationToLang
     *
     * @param \AppBundle\Entity\Crowding\TranslationToLang $translationToLang
     *
     * @return Translation
     */
    public function addTranslationToLang(\AppBundle\Entity\Crowding\TranslationToLang $translationToLang)
    {
        $this->translationToLang[] = $translationToLang;

        return $this;
    }

    /**
     * Remove translationToLang
     *
     * @param \AppBundle\Entity\Crowding\TranslationToLang $translationToLang
     */
    public function removeTranslationToLang(\AppBundle\Entity\Crowding\TranslationToLang $translationToLang)
    {
        $this->translationToLang->removeElement($translationToLang);
    }

    /**
     * Get translationToLang
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTranslationToLang()
    {
        return $this->translationToLang;
    }
}
