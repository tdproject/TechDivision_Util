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

/**
 * Interface of all datasource objects.
 *
 * @package TechDivision_Util_Interfaces
 * @author Tim Wagner <t.wagner@techdivision.com>
 * @copyright TechDivision GmbH
 * @link http://www.techdivision.com
 * @license GPL
 */
interface TechDivision_Util_Interfaces_DataSource
{

    /**
     * This method returns the name
     * of the datasource.
     *
     * @return string The name of the datasource
     */
	public function getName();

    /**
     * This method returns the name or the ip of
     * the host the the manager should connect to.
     *
     * @return string The name or the ip of the host
     */
	public function getHost();

    /**
     * This method returns the port number
     * necessary for the connection.
     *
     * @return integer The port number for the connection
     */
	public function getPort();

    /**
     * This method returns the name
     * of the database.
     *
     * @return string The name of the database
     */
	public function getDatabase();

    /**
     * This method returns the name
     * of the database driver.
     *
     * @return string The name of the database driver
     */
	public function getDriver();

    /**
     * This method returns the username
     * necessary for the database connection.
     *
     * @return string The username for the database connection
     */
	public function getUser();

    /**
     * This method returns the password
     * necessary for the database connection.
     *
     * @return string The password for the database connection
     */
	public function getPassword();

    /**
	 * This method returns additional options
	 * for the connection.
	 *
	 * @return array Holds additional options for the connection
	 */
	public function getOptions();

    /**
	 * This method returns the default connection encoding.
	 *
	 * @return string Holds the default connection encoding
	 */
	public function getEncoding();

    /**
	 * This method returns the flag to set autocommit on or off.
	 *
	 * @return boolean Holds the flag to set autocommit on or off
	 */
	public function getAutocommit();

   	/**
	 * This method returns the connection string (DSN)
	 * for connecting to the specified datasource.
	 *
	 * @return string Holds the connection string to connect to the specified database
	 */
	public function getConnectionString();
}