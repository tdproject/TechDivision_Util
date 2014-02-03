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

require_once 'TechDivision/Collections/HashMap.php';
require_once 'TechDivision/Util/AbstractDataSource.php';

/**
 * This is the data source implementation used for
 * holding the information from the XML file.
 *
 * @package TechDivision_Util
 * @author Tim Wagner <t.wagner@techdivision.com>
 * @copyright TechDivision GmbH
 * @link http://www.techdivision.com
 * @license GPL
 */
class TechDivision_Util_XMLDataSource
    extends TechDivision_Util_AbstractDataSource {

   	/**
	 * This is the factory method to create a new instance of the
	 * DataSource from the information passed as a parameter.
	 *
	 * @param SimpleXMLElement $sxe
	 * 		Holds the information to initialize the DataSource with
	 * @return TechDivision_Util_XMLDataSource Holds the initialized DataSource
	 */
    public static function create(SimpleXMLElement $sxe) {
		// initialize the accepted boolean values
    	$boolean = array(
    		"true" => true,
    		"false" => false,
    		"1" => true,
    		"0" => false,
    		"on" => true,
    		"off" => false
    	);
    	// initialize the autocommit value
    	if (!array_key_exists((string) $sxe->autocommit, $boolean)) {
    		$autocommit = false;
    	} else {
    		$autocommit = $boolean[(string) $sxe->autocommit];
    	}
        // initialize and return the data source
		return new TechDivision_Util_XMLDataSource(
		    (string)  $sxe->type,
		  	(string)  $sxe->name,
		  	(string)  $sxe->host,
		  	(integer) $sxe->port,
		 	(string)  $sxe->database,
		  	(string)  $sxe->driver,
		  	(string)  $sxe->user,
		  	(string)  $sxe->password,
		  	(string)  $sxe->encoding,
		  	$autocommit
        );
    }

    /**
     * This method is the factory method to create a new instance
     * of the DataSource from a descriptor file with at least one
     * <datasource> element.
     *
     * The method instanciates and returns the DataSource with the
     * passed name, if found, or null optional.
     *
     * @param string $name
     * 		Holds the name of the DataSource to instanciate and return
     * @param string $descriptor
     * 		Holds the path and filename of the descriptor with the
     * 		datasource definitions
     * @return TechDivision_Util_XMLDataSource
     * 		The initialized DataSource instance
     * @throws Exception
     * 		Is thrown if the descriptor can not be opened or the reqeusted
     * 		<datasource> element is not defined in the descriptor
     */
    public static function createByName($name, $descriptor) {
    	// read the descriptors content
    	if (($content = file_get_contents($descriptor, true)) === false) {
    		throw new Exception(
    			'The descriptor file ' . $descriptor . ' can not be opened'
    		);
    	}
		// create a new xml element from the datasource
    	$sxe = new SimpleXMLElement($content);
		// iterate over the data sources and add them
		foreach ($sxe->xpath('//datasources/datasource') as $element) {
			// initialize the data source
			if ((string) $element->name == $name) {
				return TechDivision_Util_XMLDataSource::create($element);
			}
		}
		// throw an exception if the descriptor does not contain
		// a <datasource> element with the passed name
		throw new Exception(
			'The datasource ' . $name . ' is not defined in descriptor file '
		    . $descriptor
		);
    }

    /**
     * This method is the factory method to create a HashMap with
     * all DataSources from a descriptor file with the passed type.
     *
     * The method instanciates and returns a HashMap with the
     * DataSource instances with the passed type, if found, or
	 * an empty HashMap if no datasources with the passed type
	 * are defined in the desriptor.
     *
     * @param string $type 	Holds the type of the DataSource instances to return
     * @param string $descriptor 	Holds the path and filename of the
     * 								descriptor with the datasource definitions
     * @return TechDivision_Collections_HashMap 	A HashMap with all
     * 												initialized DataSource
     * 												instances of the passed type
     * @throws Exception Is thrown if the passed type is not available
     * @throws Exception 	Is thrown if the descriptor can not be opened or the
     * 						requested <datasource> element is not defined in the
     * 						descriptor
     */
    public static function createByType($type, $descriptor) {
		// check if the passed type is available and valid
    	if (!TechDivision_Util_AbstractDataSource::isValidType($type)) {
    		throw new Exception(
    			'Invalid type ' . $type . ' for DataSource requested'
    		);
    	}
    	// read the descriptors content
    	if (($content = file_get_contents($descriptor, true)) === false) {
    		throw new Exception(
    			'The descriptor file ' . $descriptor . ' can not be opened'
    		);
    	}
    	// initialize the HashMap for the DataSource instances
    	$map = new TechDivision_Collections_HashMap();
		// create a new xml element from the datasource
    	$sxe = new SimpleXMLElement($content);
		// iterate over the data sources and add them
		foreach($sxe->xpath('//datasources/datasource') as $element) {
			// initialize the data source
			if((string) $element->type == $type) {
				// initialize the datasource and add it to the HashMap
				$map->add(
				    (string) $element->name,
				    TechDivision_Util_XMLDataSource::create($element));
			}
		}
		// returns the HashMap with the initialized DataSource instances
		return $map;
    }
}