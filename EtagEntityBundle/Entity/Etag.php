<?php

namespace Ito\EtagEntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Etag
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Etag
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
     * @ORM\Column(name="alias", type="string", length=255)
     */
    private $alias;

    /**
     * @var string
     *
     * @ORM\Column(name="etag", type="string", length=255)
     */
    private $etag;


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
     * Set alias
     *
     * @param string $alias
     * @return Etag
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
    
        return $this;
    }

    /**
     * Get alias
     *
     * @return string 
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set etag
     *
     * @param string $etag
     * @return Etag
     */
    public function setEtag($etag)
    {
        $this->etag = $etag;
    
        return $this;
    }

    /**
     * Get etag
     *
     * @return string 
     */
    public function getEtag()
    {
        return $this->etag;
    }
}
