<?php

namespace SpecShaper\CalendarBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;

class PersistedEventManager
{
    protected $objectManager;
    protected $class;
    protected $repository;

    /**
     * Constructor.
     *
     * @param EncoderFactoryInterface $encoderFactory
     * @param CanonicalizerInterface  $usernameCanonicalizer
     * @param CanonicalizerInterface  $emailCanonicalizer
     * @param ObjectManager           $om
     * @param string                  $class
     */
    public function __construct(ObjectManager $om, $class)
    {
        $this->objectManager = $om;
        $this->repository = $om->getRepository($class);

        $metadata = $om->getClassMetadata($class);
        $this->class = $metadata->getName();
    }

    public function createEvent()
    {
        $class = $this->class;

        return new $class();
    }

    /**
     * {@inheritdoc}
     */
    public function getClass()
    {
        return $this->class;
    }

    public function getEvent($id)
    {
        return $this->repository->find($id);
    }

    public function save($event)
    {
        $om = $this->objectManager;
        $om->persist($event);
        $om->flush();

        return $event;
    }
}
