<?php

/**
 * SpecShaper\CalendarBundle\Validator\Constraints\ReoccuranceCompleteValidator.php
 * 
 * LICENSE: Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential. SpecShaper is an SaaS product and no license is
 * granted to copy or distribute the source files.
 * 
 * @author     Written by Mark Ogilvie <mark.ogilvie@specshaper.com>, 2 2016
 * @copyright  (c) 2016, SpecShaper - All rights reserved
 * @license    http://URL name
 * @version     Release: 1.0.0
 * @since       Available since Release 1.0.0
 */

namespace SpecShaper\CalendarBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use SpecShaper\CalendarBundle\Model\CalendarReoccuranceInterface;
use DateTime;

/**
 * Description of ReoccuranceCompleteValidator
 *
 * @author      Mark Ogilvie <mark.ogilvie@specshaper.com>
 * @copyright   (c) 2015, SpecShaper - All rights reserved
 * @license     http://URL name
 * @version     Release: 1.0.0
 * @since       Available since Release 1.0.0
 */
class ReoccuranceCompleteValidator extends ConstraintValidator {
   
    public function validate($entity, Constraint $constraint)
    {      
        
        if($entity->getPeriod() !== null && $entity->getIntervalBetween() < 1){
           $this->context->buildViolation('mustProvideAnInterval')
                        
                ->atPath('intervalBetween') // This is the entity field that the alert will be shown in.
                

              //  ->setParameter('%string%', $entity)
                ->addViolation(); 
        }
        
        if( $entity->getStopMethod() === CalendarReoccuranceInterface::END_ITERATIONS){
            
            if($entity->getIterations() === null || $entity->getIterations() === ' ' || $entity->getIterations()  < 1 ){
                $this->context->buildViolation($constraint->message)
                        
                ->atPath('iterations') // This is the entity field that the alert will be shown in.
                

              //  ->setParameter('%string%', $entity)
                ->addViolation();
            }
            
        }
        
        if( $entity->getStopMethod() === CalendarReoccuranceInterface::END_DATE){
            
            if($entity->getEndDate() === null || $entity->getEndDate() === ' '){
                $this->context->buildViolation('notEmpty')
                        
                ->atPath('endDate') // This is the entity field that the alert will be shown in.
                

              //  ->setParameter('%string%', $entity)
                ->addViolation();
            }
            
            $now = new DateTime('now');
            
            if($entity->getEndDate() < $now){
                $this->context->buildViolation("futureDate")
                        
                ->atPath('endDate') // This is the entity field that the alert will be shown in.
                

              //  ->setParameter('%string%', $entity)
                ->addViolation();
            }
            
        }

        
    }
}


