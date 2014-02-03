<?php

/**
 * License: GNU General Public License
 *
 * Copyright (c) 2009 TechDivision GmbH.  All rights reserved.
 * Note: Original work copyright to respective authors
 *
 * This file is part of TechDivision GmbH - Connect.
 *
 * TechDivision_Utilis free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * TechDivision_Utilis distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307,
 * USA.
 *
 * @package TechDivision_Util
 */

require_once 'TechDivision/Util/SystemLocale.php';
require_once 'TechDivision/Collections/Interfaces/Predicate.php';

/**
 * This class is the predicate for checking the passed
 * SystemLocale to be in the ArrayList with the installed
 * system locales.
 *
 * @package TechDivision_Util
 * @author Tim Wagner <t.wagner@techdivision.com>
 * @copyright TechDivision GmbH
 * @link http://www.techdivision.com
 * @license GPL
 */
class TechDivision_Util_Predicates_SystemLocaleExists
    implements TechDivision_Collections_Interfaces_Predicate {

    /**
	 * Holds the SystemLocale the check the system locales for
	 * @var TechDivision_Util_SystemLocale
	 */
    private $_locale = null;

    /**
     * Constructor that initializes the internal member
     * with the value passed as parameter.
     *
     * @param TechDivision_Util_SystemLocale $locale
     * 		Holds the locale to check the system locales for
     * @return void
     */
    public function __construct(TechDivision_Util_SystemLocale $locale) {
		// set the Locale to check for
        $this->_locale = $locale;
    }

    /**
     * This method evaluates the objects passed as parameter against
     * the internal member and returns true if the locales are equal.
     *
     * @param TechDivision_Util_SystemLocale $object
     * 		Holds the object for the evaluation
     * @return boolean
     * 		Returns TRUE if the passed Locale equals to the internal one
     */
    public function evaluate($object) {
        // if the passed SystemLocale are equal
        if ($this->_locale->__toString() === $object->__toString()) {
            // return TRUE
        	return true;
        }
        // if not, return FALSE
        return false;
    }
}