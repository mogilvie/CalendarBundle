<?php

/**
 * @author     Written by Mark Ogilvie <mark.ogilvie@specshaper.com>, 2 2016
 */

namespace SpecShaper\CalendarBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Description of ReoccuranceConstraint
 *
 * @author      Mark Ogilvie <mark.ogilvie@specshaper.com>
 * @Annotation
 */
class ReoccuranceComplete extends Constraint {

    public $message = 'The string "%string%" contains an illegal character: it can only contain letters or numbers.';

    public function validatedBy() {
        return get_class($this) . 'Validator';
    }
    
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

}
