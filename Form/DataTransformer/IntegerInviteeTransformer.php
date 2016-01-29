<?php

/**
 * SpecShaper/CalendarBundle/Form/DataTransformer/IntergerToInviteeTransformer.php
 * 
 * @author     Written by Mark Ogilvie <mark.ogilvie@specshaper.com>, 1 2016
 */
namespace SpecShaper\CalendarBundle\Form\DataTransformer;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Collections\ArrayCollection;

use SpecShaper\CalendarBundle\Model\InviteeInterface;


/**
 * Description of IntergerToInviteeTransformer
 *
 * @author      Mark Ogilvie <mark.ogilvie@specshaper.com>
 */
class IntegerInviteeTransformer implements DataTransformerInterface
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Transforms an Invitee object (issue) to an integer (number).
     *
     * @param  InviteeInterface|null $issue
     * @return string
     */
    public function reverseTransform($inviteeCollection)
    {
//        $returnArray = new ArrayCollection();
//        
//        if (null === $inviteeCollection) {
//            return '';
//        }
//        
//        foreach($inviteeCollection as $invitee){
//            $returnArray->add($invitee->getId());
//        }
//        
//        var_dump($returnArray);
//
//        return $returnArray;.
        return $inviteeCollection;
    }

    /**
     * Transforms a integer[] (number) to an Invitee object (issue).
     *
     * @param  string $issueNumber
     * @return InviteeInterface|null
     * @throws TransformationFailedException if object (issue) is not found.
     */
    public function transform($integerArray)
    {
        
        // no issue number? It's optional, so that's ok
        if (!$integerArray) {
            return;
        }

        $invitees = $this->manager
            ->getRepository('AppBundle:CalendarInvitee')
            // query for the issue with this id
            ->findAll()
        ;
        
        if (null === $invitees) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'An issue with number "%s" does not exist!',
                $invitees
            ));
        }

        return $invitees;
    }
}