<?php

namespace AppBundle\Entity\Crowding;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Lang
 *
 * @ORM\Table(name="lang")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Crowding\LangRepository")
 * @JMS\ExclusionPolicy("all")
 */
class Lang
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="code", type="string", length=5)
     */
    private $code;

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
     * Set code
     *
     * @param string $code
     *
     * @return Lang
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }
}
