<?php

namespace AppBundle\Entity\Crowding;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * TranslationToLang
 *
 * @ORM\Table(name="translation_to_lang")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Crowding\TranslationToLangRepository")
 * @JMS\ExclusionPolicy("all")
 */
class TranslationToLang
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Crowding\Translation", fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $translation;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Crowding\Lang", fetch="EAGER")
     * @ORM\JoinColumn(nullable=false, referencedColumnName="code")
     */
    private $lang;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $trans;

    public function __toString() {
        return $this->lang->getCode().'-'.$this->translation->getCode();
    }

    /**
     * Set trans
     *
     * @param string $trans
     *
     * @return TranslationToLang
     */
    public function setTrans($trans)
    {
        $this->trans = $trans;

        return $this;
    }

    /**
     * Get trans
     *
     * @return string
     */
    public function getTrans()
    {
        return $this->trans;
    }

    /**
     * Set translation
     *
     * @param \AppBundle\Entity\Crowding\Translation $translation
     *
     * @return TranslationToLang
     */
    public function setTranslation(\AppBundle\Entity\Crowding\Translation $translation)
    {
        $this->translation = $translation;

        return $this;
    }

    /**
     * Get translation
     *
     * @return \AppBundle\Entity\Crowding\Translation
     */
    public function getTranslation()
    {
        return $this->translation;
    }

    /**
     * Set lang
     *
     * @param \AppBundle\Entity\Crowding\Lang $lang
     *
     * @return TranslationToLang
     */
    public function setLang(\AppBundle\Entity\Crowding\Lang $lang)
    {
        $this->lang = $lang;

        return $this;
    }

    /**
     * Get lang
     *
     * @return \AppBundle\Entity\Crowding\Lang
     */
    public function getLang()
    {
        return $this->lang;
    }
}
