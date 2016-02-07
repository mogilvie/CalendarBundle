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
class LogicalEndDate extends Constraint {

    public $message = 'spec_shaper_bundle.endMustBeAfterStart';

    public function validatedBy() {
        return get_class($this) . 'Validator';
    }
    
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

}
