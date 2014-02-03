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

require_once 'TechDivision/Lang/Boolean.php';
require_once 'TechDivision/Collections/HashMap.php';
require_once 'TechDivision/Util/AbstractDataSource.php';
require_once 'TechDivision/Util/Exceptions/InvalidConnectionTypeException.php';
require_once 'TechDivision/Properties/Properties.php';

/**
 * This is the data source implementation used for
 * holding the information from a property file.
 *
 * @package TechDivision_Util
 * @author Tim Wagner <t.wagner@techdivision.com>
 * @copyright TechDivision GmbH
 * @link http://www.techdivision.com
 * @license GPL
 */
class TechDivision_Util_DataSource
    extends TechDivision_Util_AbstractDataSource {

	/**
	 * Holds the database type to use, can be one of
	 * dedicated, master, slave or backup.
	 * @var string
	 */
	const DB_CONNECT_TYPE = "db.connect.type";

	/**
	 * Holds the database driver to use, whereas all database drivers of
	 * the PEAR MDB2 package are supported.
	 * @var string
	 */
	const DB_CONNECT_DRIVER = "db.connect.driver";

	/**
	 * Holds the name of the database connection.
	 * @var string
	 */
	const DB_CONNECT_NAME = "db.connect.name";

	/**
	 * Holds the username for the database connection.
	 * @var string
	 */
	const DB_CONNECT_USER = "db.connect.user";

	/**
	 * Holds the password for the database connect.
	 * @var string
	 */
	const DB_CONNECT_PASSWORD = "db.connect.password";

	/**
	 * Holds the host to connect to.
	 * @var string
	 */
	const DB_CONNECT_HOST = "db.connect.host";

	/**
	 * Holds the port for the connection.
	 * @var string
	 */
	const DB_CONNECT_PORT = "db.connect.port";

	/**
	 * Holds the database name to connect to.
	 * @var string
	 */
	const DB_CONNECT_DATABASE = "db.connect.database";

	/**
	 * Holds the database encoding to connect with.
	 * @var string
	 */
	const DB_CONNECT_ENCODING = "db.connect.encoding";

	/**
	 * Holds the string with the additional connection information,
	 * e. g. option1=value1&option2=value2&...
	 * @var string
	 */
	const DB_CONNECT_OPTIONS = "db.connect.options";

	/**
	 * Holds the flag for turning autocommit on or off.
	 * @var string
	 */
	const DB_CONNECT_AUTOCOMMIT = "db.connect.autocommit";

   	/**
	 * This is the factory method to create a new instance of the
	 * DataSource from the information passed as a parameter.
	 *
	 * @param TechDivision_Properties_Properties $properties
	 * 		Holds the information to initialize the DataSource with
	 * @return TechDivision_Util_DataSource Holds the initialized DataSource
	 * @throws TechDivision_Util_Exceptions_InvalidConnectionTypeException
	 * 		Is thrown if an invalid connection type was specified
	 */
    public static function create(
        TechDivision_Properties_Properties $properties) {
        // load the connection type
		$type = $properties->getProperty(
	        TechDivision_Util_DataSource::DB_CONNECT_TYPE
	    );
        // if a connection type was set, validate it
	    if (!empty($type)) {
            // validate the connection type
    	    if (!TechDivision_Util_AbstractDataSource::isValidType($type)) {
    	        throw new
    	            TechDivision_Util_Exceptions_InvalidConnectionTypeException(
        	        	'Invalid connection type ' . $type . ' specified, use ' .
        	        	'one of dedicated, master, slave or backup'
        	        );
    	    }
	    } else {
	        $type = TechDivision_Util_AbstractDataSource::DEDICATED;
	    }
        // load the autocommit flag
	    $autocommit = new TechDivision_Lang_String(
	        $properties->getProperty(
	            TechDivision_Util_DataSource::DB_CONNECT_AUTOCOMMIT
	        )
	    );
        // initialize and return the data source
		return new TechDivision_Util_DataSource(
		    $type,
		    $properties->getProperty(
		        TechDivision_Util_DataSource::DB_CONNECT_NAME
		    ),
		    $properties->getProperty(
		        TechDivision_Util_DataSource::DB_CONNECT_HOST
		    ),
		    $properties->getProperty(
		        TechDivision_Util_DataSource::DB_CONNECT_PORT
		    ),
		    $properties->getProperty(
		        TechDivision_Util_DataSource::DB_CONNECT_DATABASE
		    ),
		    $properties->getProperty(
		        TechDivision_Util_DataSource::DB_CONNECT_DRIVER
		    ),
		    $properties->getProperty(
		        TechDivision_Util_DataSource::DB_CONNECT_USER
		    ),
		    $properties->getProperty(
		        TechDivision_Util_DataSource::DB_CONNECT_PASSWORD
		    ),
		    $properties->getProperty(
		        TechDivision_Util_DataSource::DB_CONNECT_ENCODING
		    ),
		    $properties->getProperty(
		        TechDivision_Util_DataSource::DB_CONNECT_OPTIONS
		    ),
		  	TechDivision_Lang_Boolean::valueOf($autocommit)->booleanValue()
        );
    }
}