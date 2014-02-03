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

require_once 'TechDivision/Lang/Object.php';

/**
 * This is a factory class to create new object instances.
 *
 * @package TechDivision_Util
 * @author Tim Wagner <t.wagner@techdivision.com>
 * @copyright TechDivision GmbH
 * @link http://www.techdivision.com
 * @license GPL
 */
class TechDivision_Util_Object_Factory extends TechDivision_Lang_Object
{
    /**
     * The singleton instance.
     * @var TechDivision_Util_Object_Factory
     */
    protected static $_instance = null;

    /**
     * Protect class because we want to use singleton pattern.
     *
     * @return void
     */
    protected function __construct()
    {
        // prevents class from direct initialization (singleton)
    }

    /**
     * Singleton method.
     *
     * @return TechDivision_Util_Object_Factory The singleton
     */
    public static function get()
    {
        // initialize and return the instance
        if (self::$_instance == null) {
            self::$_instance = new TechDivision_Util_Object_Factory();
        }
        return self::$_instance;
    }

    /**
     * Factory method for a new instance of the
     * class with the passed name.
     *
     * @param string Name of the class to create and return the oject for
     * @param array The arguments passed to the classes constructor
	 * @return TechDivision_Lang_Object The instance
     */
    public function newInstance($className, array $arguments = array())
    {
        // instanciate the return the object
        $reflectionClass = new ReflectionClass($className);
        // check if a constructor is available
        if ($reflectionClass->hasMethod('__construct')) {
        	return $reflectionClass->newInstanceArgs($arguments);   	
        }
        // create a new instance WITHOUT constructor
        return $reflectionClass->newInstance();
    }
}