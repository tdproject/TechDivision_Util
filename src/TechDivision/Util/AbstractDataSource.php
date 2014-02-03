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

require_once "TechDivision/Lang/Object.php";
require_once "TechDivision/Util/Interfaces/DataSource.php";

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
class TechDivision_Util_AbstractDataSource
    extends TechDivision_Lang_Object
    implements TechDivision_Util_Interfaces_DataSource {

	/**
	 * Holds the string for the database type 'session'.
	 * @var string
	 */
	const SESSION = "session";

	/**
	 * Holds the string for the database type 'master'.
	 * @var string
	 */
	const MASTER = "master";

	/**
	 * Holds the string for the database type 'slave'.
	 * @var string
	 */
	const SLAVE = "slave";

	/**
	 * Holds the string for the database type 'dedicated'.
	 * @var string
	 */
	const DEDICATED = "dedicated";

	/**
	 * Holds the type of the data source
	 * (can be session, master, slave or dedicated).
	 * @var string
	 */
    private $_type = null;

	/**
	 * Holds the data source unique name.
	 * @var string
	 */
    private $_name = null;

	/**
	 * Holds the name of the database driver to connect with.
	 * @var string
	 */
    private $_driver = null;

	/**
	 * Holds the ip address or the domain name of the host to connect.
	 * @var string
	 */
    private $_host = null;

	/**
	 * Holds the port used to connect.
	 * @var integer
	 */
    private $_port = null;

	/**
	 * Holds the name of the database to connect.
	 * @var string
	 */
    private $_database = null;

	/**
	 * Holds the username to use for the connection.
	 * @var string
	 */
    private $_user = null;

	/**
	 * Holds the password to use for the connection.
	 * @var string
	 */
    private $_password = null;

    /**
	 * Holds additional options for the connection.
	 * @var array
	 */
    private $_options = array();

    /**
	 * Holds additional options for the connection.
	 * @var array
	 */
    private $_encoding = "utf8";

    /**
	 * True if autocommit has to be turned on, else false.
	 * @var boolean
	 */
    private $_autocommit = false;

    /**
	 * The constructor initializes the data
	 * source with the passed information.
	 *
	 * The passed information is used to concatenate the connection string
	 * (DSN) used to connect to the database.
	 *
	 * @param string $type
	 * 		Holds the type of the data source (can be session, master,
	 * 		slave or dedicated)
	 * @param string $name Holds the data source unique name
	 * @param string $host
	 * 		Holds the ip address or the domain name of the host to connect
	 * @param integer $port Holds the port used to connect
	 * @param string $database Holds the name of the database to connect
	 * @param string $driver
	 * 		Holds the name of the database driver to connect with
	 * @param string $user Holds the username to use for the connection
	 * @param string $password Holds the password to use for the connection
	 * @param string $encoding
	 * 		Holds the default encoding (utf8) to use for the connection
	 * @param string $options
	 * 		Holds the options to use for the connection
	 * @param boolean $autocommit
	 * 		TRUE if autocommit has to be turned on, else FALSE
	 * @return void
	 */
    public function __construct(
        $type,
        $name,
        $host,
        $port,
        $database,
        $driver,
        $user,
        $password,
        $encoding = "utf8",
        $options = '',
        $autocommit = false) {
		$this->_setType($type);
		$this->_setName($name);
		$this->_setHost($host);
		$this->_setPort($port);
		$this->_setDatabase($database);
		$this->_setDriver($driver);
		$this->_setUser($user);
		$this->_setPassword($password);
		$this->_setEncoding($encoding);
		$this->_setOptions($options);
		$this->_setAutocommit($autocommit);
    }

    /**
	 * This method returns the type of the data source.
	 *
	 * @return string Holds the type of the data source
	 * @see TechDivision_Util_Interfaces_DataSource::getType()
	 */
    public function getType()
    {
    	return $this->_type;
    }

    /**
	 * This method returns the unique name of the data source.
	 *
	 * @return string Holds the unique name of the data source
	 * @see TechDivision_Util_Interfaces_DataSource::getName()
	 */
    public function getName()
    {
    	return $this->_name;
    }

    /**
	 * This method returns the ip address or the domain name of the
	 * host to connect.
	 *
	 * @return string 	Holds the ip address or the domain name of the
	 * 					host to connect
	 * @see TechDivision_Util_Interfaces_DataSource::getHost()
	 */
    public function getHost()
    {
    	return $this->_host;
    }

    /**
	 * This method returns the port to connect.
	 *
	 * @return integer Holds the port to connect
	 * @see TechDivision_Util_Interfaces_DataSource::getPort()
	 */
    public function getPort()
    {
    	return $this->_port;
   	}

    /**
	 * This method returns the name of the database to connect.
	 *
	 * @return string Holds the name of the database to connect
	 * @see TechDivision_Util_Interfaces_DataSource::getDatabase()
	 */
    public function getDatabase()
    {
    	return $this->_database;
    }

    /**
	 * This method returns the name of the database driver to connect with.
	 *
	 * @return string Holds name of the database driver to connect with
	 * @see TechDivision_Util_Interfaces_DataSource::getDriver()
	 */
    public function getDriver()
    {
    	return $this->_driver;
    }

    /**
	 * This method returns the username to use for the connection.
	 *
	 * @return string Holds the username to use for the connection
	 * @see TechDivision_Util_Interfaces_DataSource::getUser()
	 */
    public function getUser()
    {
    	return $this->_user;
   	}

    /**
	 * This method returns the password to use for the connection.
	 *
	 * @return string Holds the password to use for the connection
	 * @see TechDivision_Util_Interfaces_DataSource::getPassword()
	 */
    public function getPassword()
    {
    	return $this->_password;
   	}

    /**
	 * This method returns additional options for the connection.
	 *
	 * @return array Holds additional options for the connection
	 * @see TechDivision_Util_Interfaces_DataSource::getOptions()
	 */
    public function getOptions()
    {
    	return $this->_options;
   	}

    /**
	 * This method returns the default connection encoding.
	 *
	 * @return string Holds the default connection encoding
	 * @see TechDivision_Util_Interfaces_DataSource::getEncoding()
	 */
    public function getEncoding()
    {
    	return $this->_encoding;
   	}

    /**
	 * This method returns true if autocommit has to be turned on, else false.
	 *
	 * @return boolean True if autocommit has to be turned on, else false
	 * @see TechDivision_Util_Interfaces_DataSource::getAutocommit()
	 */
    public function getAutocommit()
    {
    	return $this->_autocommit;
   	}

    /**
	 * This method sets the type of the data source.
	 *
	 * @param string $type Holds the type of the data source
	 * @return void
	 */
    private function _setType($type)
    {
    	$this->_type = $type;
    }

    /**
	 * This method sets the unique name of the data source.
	 *
	 * @param string $name Holds the unique name of the data source
	 * @return void
	 */
    private function _setName($name)
    {
    	$this->_name = $name;
   	}

    /**
	 * This method sets the ip address or the domain name of the
	 * host to connect.
	 *
	 * @param string $host 	Holds the ip address or the domain name of the
	 * 						host to connect
	 * @return void
	 */
    private function _setHost($host)
    {
    	$this->_host = $host;
    }

    /**
	 * This method sets the the port to connect.
	 *
	 * @param integer $port Holds the port to connect
	 * @return void
	 */
    private function _setPort($port)
    {
    	$this->_port = $port;
   	}

    /**
	 * This method sets the name of the database to connect.
	 *
	 * @param string $database Holds the name of the database to connect
	 * @return void
	 */
    private function _setDatabase($database)
    {
    	$this->_database = $database;
    }

    /**
	 * This method sets the name of the database driver to connect with.
	 *
	 * @param string $driver 	Holds the name of the database driver
	 * 							to connect with
	 * @return void
	 */
    private function _setDriver($driver)
    {
    	$this->_driver = $driver;
    }

    /**
	 * This method sets the username to use for the connection.
	 *
	 * @param string $user Holds the username to use for the connection
	 * @return void
	 */
    private function _setUser($user)
    {
    	$this->_user = $user;
    }

    /**
	 * This method sets the password to use for the connection.
	 *
	 * @param string $password Holds the password to use for the connection
	 * @return void
	 */
    private function _setPassword($password)
    {
    	$this->_password = $password;
   	}

    /**
	 * This method sets additional options for the connection.
	 *
	 * @param string $options Holds additional options for the connection
	 * @return void
	 */
    private function _setOptions($options)
    {
        $this->_options = $options;
   	}

    /**
	 * This method sets the default connection encoding.
	 *
	 * @param string $encoding Holds the default connection encoding
	 * @return void
	 */
    private function _setEncoding($encoding) {
    	$this->_encoding = $encoding;
   	}

    /**
	 * True if autocommit has to be turned on, else false.
	 *
	 * @param boolean $autocommit 	True if autocommit has to be
	 * 								turned on, else false
	 * @return void
	 */
    private function _setAutocommit($autocommit)
    {
    	$this->_autocommit = $autocommit;
   	}

   	/**
	 * This method returns the connection string (DSN)
	 * for connecting to the specified datasource by
	 * the PEAR MDB2 package.
	 *
	 * The DSN has the following layout:
	 *
	 *     driver://username:password@host:port/database
	 *     		?optionname1=optionvalue1&optionname2=optionvalue2
	 *
	 * @return string 	Holds the connection string to connect
	 * 					to the specified database
	 * @see TechDivision_Util_Interfaces_DataSource::getConnectionString()
	 */
   	public function getConnectionString()
   	{
   		return $this->__toString();
   	}

   	/**
   	 * This method checks if the passed type is
   	 * available.
   	 *
   	 * @param string $type Holds the requested type
   	 * @return boolean TRUE if the passed type is available, else FALSE
   	 */
   	public static function isValidType($type)
   	{
		// initialize the array with the available types
   		$types = array(
   			TechDivision_Util_AbstractDataSource::DEDICATED,
   			TechDivision_Util_AbstractDataSource::MASTER,
   			TechDivision_Util_AbstractDataSource::SESSION,
   			TechDivision_Util_AbstractDataSource::SLAVE
   		);
   		// check if the passed type is in the array with the available types
   		return in_array($type, $types);
   	}

   	/**
	 * @see TechDivision_Util_Interfaces_DataSource::getConnectionString();
	 */
   	public function __toString()
   	{
   		$dsn = "";
   		$dsn .= $this->getDriver() . "://" . $this->getUser();
   		$password = $this->getPassword();
   		if (!empty($password)) {
   		    // add the password if specified
   			$dsn .= ":" . $password;
   		}
   		$dsn .= "@" . $this->getHost();
   		$port = $this->getPort();
   		if (!empty($port)) {
   		    // add the port if specified
   			$dsn .= ":" . $port;
   		}
   		$dsn .= "/" . $this->getDatabase();
   		$options = $this->getOptions();
   		if (!empty($options)) {
   			$dsn .= "?" . $options;
   		}
   		return $dsn;
   	}
}