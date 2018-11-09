<?php

namespace AppBundle\Entity\Crowding;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Domain
 *
 * @ORM\Table(name="domain")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Crowding\DomainRepository")
 * @JMS\ExclusionPolicy("all")
 */
class Domain
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Groups({"LIST", "DETAIL"})
     * @JMS\Expose 
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, unique=true)
     * @Gedmo\Slug(fields={"name"})
     * @JMS\Groups({"LIST", "DETAIL"})
     * @JMS\Expose 
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @JMS\Groups({"LIST", "DETAIL"})
     * @JMS\Expose 
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     * @JMS\Groups({"LIST", "DETAIL"})
     * @JMS\Expose 
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Crowding\User", fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     * @JMS\Groups({"DETAIL"})
     * @JMS\Expose 
     * @JMS\SerializedName("creator")
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Crowding\Lang")
     * @ORM\JoinTable(
     *      joinColumns={@ORM\JoinColumn(name="domain_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="lang_id", referencedColumnName="code")}
     * )     
     */
    private $langs;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     * @JMS\Expose
     * @JMS\Groups({"DETAIL"})
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Crowding\Translation", mappedBy="domain")
     */
    private $translations;

    /**
     * @JMS\VirtualProperty()
     * @JMS\Groups({"DETAIL"})
     * @JMS\SerializedName("langs")
     */
    public function getVirtualLangs()
    {
        $res = [];
        foreach ($this->getLangs() as $key => $value) {
            $res[] = $value->getCode();
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
     * Set name
     *
     * @param string $name
     *
     * @return Domain
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Domain
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\Crowding\User $user
     *
     * @return Domain
     */
    public function setUser(\AppBundle\Entity\Crowding\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\Crowding\User
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->langs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add lang
     *
     * @param \AppBundle\Entity\Crowding\Lang $lang
     *
     * @return Domain
     */
    public function addLang(\AppBundle\Entity\Crowding\Lang $lang)
    {
        $this->langs[] = $lang;

        return $this;
    }

    /**
     * Remove lang
     *
     * @param \AppBundle\Entity\Crowding\Lang $lang
     */
    public function removeLang(\AppBundle\Entity\Crowding\Lang $lang)
    {
        $this->langs->removeElement($lang);
    }

    /**
     * Get langs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLangs()
    {
        return $this->langs;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Domain
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Domain
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Add translation
     *
     * @param \AppBundle\Entity\Crowding\Translation $translation
     *
     * @return Domain
     */
    public function addTranslation(\AppBundle\Entity\Crowding\Translation $translation)
    {
        $this->translations[] = $translation;

        return $this;
    }

    /**
     * Remove translation
     *
     * @param \AppBundle\Entity\Crowding\Translation $translation
     */
    public function removeTranslation(\AppBundle\Entity\Crowding\Translation $translation)
    {
        $this->translations->removeElement($translation);
    }

    /**
     * Get translations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTranslations()
    {
        return $this->translations;
    }
}
