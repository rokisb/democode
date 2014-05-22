<?php

namespace Ito\WifiBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Ito\WifiBundle\Entity\Country;

class CityRepository extends EntityRepository
{

    public function findAllCitiesByCountryId($countryId)
    {

        $batchSize = 10;
        $i = 0;
        $em = $this->getEntityManager();
        $q = $em->createQuery('select c from ItoWifiBundle:City c WHERE c.country = :country')->setParameter('country', $countryId);

        $iterableResult = $q->iterate();
        $data = array();

        foreach($iterableResult AS $row) {
            $city = $row[0];
            if($city->getActive() && $city->getName() != '') {
                $data[] = array('id'    => $city->getId(),
                                'name'  => $city->getName());
            }

            if (($i % $batchSize) == 0) {
                $em->clear();
            }
            ++$i;
        }

        return $data;

    }

}
