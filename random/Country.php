<?php

namespace Ito\WifiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Country
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ito\WifiBundle\Repository\CountryRepository")
 */
class Country
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
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updated;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active = false;

    /**
     * @ORM\OneToMany(targetEntity="City", mappedBy="country")
     * @ORM\OrderBy({"name" = "ASC"})
     **/
    private $cities;


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
     * @return Country
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
     * @param mixed $cities
     */
    public function setCities($cities)
    {
        $this->cities = $cities;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Scan
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
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

    /**
     * @return mixed
     */
    public function getCities()
    {
        return $this->cities;
    }

    public function toArray()
    {
        $cities = $this->cities->getValues();
        $returnCities = array();

        $showInList = false;
        foreach ($cities as $city) {
            if($city->getActive() && $city->getName() != '') {
                $returnCities[] = $city->toArray();
                $showInList = true;
            }
        }
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'showInList' => $showInList,
            'cities' => $returnCities
        );
    }
}
