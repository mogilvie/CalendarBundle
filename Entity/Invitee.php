<?php
namespace SpecShaper\CalendarBundle\Entity;
/**
 * \Invitee.php
 * 
 * LICENSE: Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential. SpecShaper is an SaaS product and no license is
 * granted to copy or distribute the source files.
 * 
 * @author     Written by Mark Ogilvie <mark.ogilvie@specshaper.com>, 1 2016
 * @copyright  (c) 2016, SpecShaper - All rights reserved
 * @license    http://URL name
 * @version     Release: 1.0.0
 * @since       Available since Release 1.0.0
 */
use SpecShaper\CalendarBundle\Model\Invitee as BaseInvitee;
/**
 * Description of Invitee
 *
 * @author      Mark Ogilvie <mark.ogilvie@specshaper.com>
 * @copyright   (c) 2015, SpecShaper - All rights reserved
 * @license     http://URL name
 * @version     Release: 1.0.0
 * @since       Available since Release 1.0.0
 */
class Invitee extends BaseInvitee{
    //put your code here
    public function __construct()
    {
        // Required to construct the SpecShaperCalendarBundle PersistedEvent
        parent::__construct();
    }
}
