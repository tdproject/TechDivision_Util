<?php

/**
 * License: GNU General Public License
 *
 * Copyright (c) 2009 TechDivision GmbH.  All rights reserved.
 * Note: Original work copyright to respective authors
 *
 * This file is part of TechDivision GmbH - Connect.
 *
 * faett.net is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * faett.net is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307,
 * USA.
 *
 * @package TechDivision_Utils
 */

require_once 'TechDivision/Properties/Properties.php';
require_once 'TechDivision/Util/DataSource.php';

/**
 * This is the test for the properties based data source class.
 *
 * @package TechDivision_Util
 * @author Tim Wagner <t.wagner@techdivision.com>
 * @copyright TechDivision GmbH
 * @link http://www.techdivision.com
 * @license GPL
 */
class TechDivision_Util_DataSourceTest extends PHPUnit_Framework_TestCase {

	/**
	 * This tests the factory method.
	 *
	 * @return void
	 */
	function testCreate()
	{
		// load the properties and initialize the data source
        $cn = TechDivision_Util_DataSource::create(
            TechDivision_Properties_Properties::create()->load(
            	'TechDivision/Util/dbutil.properties'
            )
        );
        // check the connection string
        $this->assertEquals(
            'mysqli://utilUser:utilPassword@localhost:3306/util',
            $cn->getConnectionString()
        );
        // check the connection type
        $this->assertEquals(
            TechDivision_Util_AbstractDataSource::DEDICATED,
            $cn->getType()
        );
	}
}