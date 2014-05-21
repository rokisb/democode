<?php

namespace Ito\EtagEntityBundle\Service;

use Doctrine\ORM\EntityManager;

class EtagService
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;


    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Get Etag by alias
     *
     * @return PHPExcel
     */
    public function getEtag($alias)
    {
        $etag = $this->em->getRepository("ItoEtagEntityBundle:Etag")->findOneBy(array('alias' => $alias));
        if($etag){
            return $etag->getEtag();
        }else{
            return false;
        }


    }

}