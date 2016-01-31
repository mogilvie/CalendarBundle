<?php

/**
 * \EmailAddress.php
 * 
 * LICENSE: Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential. SpecShaper is an SaaS product and no license is
 * granted to copy or distribute the source files.
 * 
 * @author     Written by Mark Ogilvie <mark.ogilvie@specshaper.com>, 1 2016
 */

namespace SpecShaper\CalendarBundle\Model;

/**
 * Description of EmailAddress
 *
 * @author      Mark Ogilvie <mark.ogilvie@specshaper.com>
 */
class EmailAddress {

    protected $address;
    
    protected $fullName;
    
    public function __construct($fullName, $address ) {
        $this->fullName = $fullName;
        $this->address = $address;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($address) {
        $this->address = $address;
        return $this;
    }

    public function getFullName() {
        return $this->fullName;
    }

    public function setFullName($fullName) {
        $this->fullName = $fullName;
        return $this;
    }
    
    public function toArray() {
        return array( 'fullName' => $this->fullName, 'address' => $this->address);
    }

}
