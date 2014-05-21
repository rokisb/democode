<?php

namespace Ito\EtagEntityBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Ito\EtagEntityBundle\Entity\Etag;

/**
 * Class EntityListener
 */
class EtagListener {

    protected $config;
    protected $entities;

    public function __construct(array $config){

        $this->config = $config;

        foreach($this->config as $alias => $entities){
            foreach($entities as $entity) {
                $this->entities[$entity] = $alias;
            }
        }

    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->index($args);
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $this->index($args);
    }
    public function preRemove(LifecycleEventArgs $args)
    {
        $this->index($args);
    }


    public function index(LifeCycleEventArgs $args)
    {
        $entityName = get_class($args->getEntity());
        $em = $args->getEntityManager();

        if(isset($this->entities[$entityName])) {

            $entity = $em->getRepository('ItoEtagEntityBundle:Etag')->findOneBy(array('alias' => $this->entities[$entityName]));
            if(!$entity) {
                $entity = new Etag();
                $entity->setAlias($this->entities[$entityName]);
            }
            $entity->setEtag(time());
            $em->persist($entity);
            $em->flush();

        }

    }

}