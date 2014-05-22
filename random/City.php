<?php

namespace Ito\WifiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Annotation;

/**
 * City
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ito\WifiBundle\Repository\CityRepository")
 */
class City
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active = false;

    /**
     * @ORM\ManyToOne(targetEntity="Country", cascade={"persist"})
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     **/
    private $country;

    /**
     * @ORM\OneToMany(targetEntity="Network", mappedBy="city")
     * @ORM\OrderBy({"name" = "ASC"})
     **/
    private $networks;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return City
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
     * Set Country entity
     *
     * @param \Ito\WifiBundle\Entity\Country $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * Get Country entity
     *
     * @return \Ito\WifiBundle\Entity\Country
     */
    public function getCountry()
    {
        return $this->country;
    }


    /**
     * @param mixed $cities
     */
    public function setNetworks($networks)
    {
        $this->networks = $networks;
    }

    /**
     * @return mixed
     */
    public function getNetworks()
    {
        return $this->networks;
    }


    /**
     * Set active
     *
     * @param boolean $active
     * @return Network
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    public function toArray()
    {

        return array(
            'id' => $this->id,
            'name' => $this->name
        );
    }


}
