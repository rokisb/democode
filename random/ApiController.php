<?php

namespace Ito\WifiV2Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Ito\WifiBundle\Entity\Network;
use Ito\WifiBundle\Form\NetworkType;
use Ito\WifiBundle\Validator\Constraints\Lat;
use Ito\WifiBundle\Validator\Constraints\Lng;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Ito\WifiBundle\Entity\Testserver;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Validator\Constraints\Range;

/**
 * @Route("/")
 */
class ApiController extends \Ito\WifiBundle\Controller\ApiController
{


    /**
     * @ApiDoc(
     *  section="Api V2",
     *  description="Get countries list",
     *     statusCodes={
     *         200="Returned when successful",
     *         304={
     *           "Returned when client have cached last version"
     *         },
     *     }
     * )
     *
     * @Route("/countries" )
     * @Method({"GET"})
     * @Template()
     *
     */
    public function getCountriesAction(Request $request){

        $etag = $this->get('ito_etag_entity.etag_entity')->getEtag('city_country');
        $response = new JsonResponse();
        $response->setEtag($etag);

        if($response->isNotModified($request)){
            return $response;
        }else{
            $cache = $this->get('beryllium_cache');

            $result = $cache->get('countries');

            if($result === false) {
                $result = $this->get('ito_wifiv2.country')->getAllCountries();
                $cache->set('countries', $result, 600);
            }

            if($result) {
                $response->setData($result);
                return $response;
            } else {
                return new JsonResponse(null, 204);
            }
        }
    }
    /**
     * @ApiDoc(
     *  section="Api V2",
     *  description="Get cities list",
     *     statusCodes={
     *         200="Returned when successful",
     *         304={
     *           "Returned when client have cached last version"
     *         },
     *     },
     *     requirements={
     *        {
     *          "name"="country_id",
     *          "dataType"="integer",
     *          "description"="*Country id",
     *          "required"=true
     *        }
     *     }
     * )
     *
     * @Route("/cities")
     * @Method({"GET"})
     * @Template()
     *
     */
    public function getCitiesAction(Request $request){

        $countryId = $request->query->get('country_id', 0);
        $response = new JsonResponse();

        $em = $this->getDoctrine()->getManager();
        $country = $em->getRepository('ItoWifiBundle:Country')->findOneBy(array('id' => $countryId, 'active' => 1));

        if($country == null){
            $response->setStatusCode(404);
            return $response;
        }

        $response->setLastModified($country->getUpdated());

        if($response->isNotModified($request)){
            return $response;
        }else{
            $cache = $this->get('beryllium_cache');
            $result = $cache->get('cities_'.$country->getId());

            if($result === false) {
                $result = $this->get('ito_wifiv2.country')->getCities($countryId);
                $cache->set('countries', $result, 600);
            }

            if($result) {
                $response->setData($result);
                return $response;
            } else {
                return new JsonResponse(null, 204);
            }
        }

    }

}
