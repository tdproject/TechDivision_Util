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

require_once 'TechDivision/Lang/String.php';
require_once 'TechDivision/Util/SystemLocale.php';

/**
 * This is the test for the Locale class.
 *
 * @package TechDivision_Util
 * @author Tim Wagner <t.wagner@techdivision.com>
 * @copyright TechDivision GmbH
 * @link http://www.techdivision.com
 * @license GPL
 */
class TechDivision_Util_SystemLocaleTest extends PHPUnit_Framework_TestCase
{

	/**
	 * This tests the constructor initialized with
	 * a language only.
	 *
	 * @return void
	 */
	public function testConstructorWithLanguage()
	{
		// initialize a new Locale instance
		$locale = new TechDivision_Util_SystemLocale(
		    new TechDivision_Lang_String("de")
		);
		// check that the result equals "de"
		$this->assertEquals("de", $locale->getLanguage()->stringValue());
		// check that country and variant are empty strings
		$this->assertEquals("", $locale->getCountry()->stringValue());
		$this->assertEquals("", $locale->getVariant()->stringValue());
		// check that the complete locale string equals "de_DE_Traditional_WIN"
		$this->assertEquals("de", $locale->toString()->stringValue());
	}

	/**
	 * This tests the constructor initialized with
	 * a language and a country.
	 *
	 * @return void
	 */
	public function testConstructorWithLanguageAndCountry()
	{
		// initialize a new Locale instance
		$locale = new TechDivision_Util_SystemLocale(
		    new TechDivision_Lang_String("de"),
		    new TechDivision_Lang_String("DE")
		);
		// check that the result equals "de"
		$this->assertEquals("de", $locale->getLanguage()->stringValue());
		// check that the result equals "DE"
		$this->assertEquals("DE", $locale->getCountry()->stringValue());
		// check that variant is an empty string
		$this->assertEquals("", $locale->getVariant()->stringValue());
		// check that the complete locale string equals "de_DE"
		$this->assertEquals("de_DE", $locale->toString()->stringValue());
	}

	/**
	 * This tests the constructor initialized with
	 * a language and a country.
	 *
	 * @return void
	 */
	public function testConstructorWithLanguageAndCountryAndVariant()
	{
		// initialize a new Locale instance
		$locale = new TechDivision_Util_SystemLocale(
		    new TechDivision_Lang_String("de"),
		    new TechDivision_Lang_String("DE"),
		    new TechDivision_Lang_String("Traditional_WIN")
		);
		// check that the result equals "de"
		$this->assertEquals("de", $locale->getLanguage()->stringValue());
		// check that the result equals "DE"
		$this->assertEquals("DE", $locale->getCountry()->stringValue());
		// check that variant equals "Traditional_WIN"
		$this->assertEquals(
			"Traditional_WIN",
		    $locale->getVariant()->stringValue()
		);
		// check that the complete locale string equals "de_DE_Traditional_WIN"
		$this->assertEquals(
			"de_DE_Traditional_WIN",
		    $locale->toString()->stringValue()
		);
	}

	/**
	 * This tests the constructor initialized with
	 * a empty language and a empty country.
	 *
	 * @return void
	 */
	public function testWithEmptyLanguage()
	{
		// set the expected exception
	    $this->setExpectedException(
	    	'TechDivision_Lang_Exceptions_NullPointerException'
	    );
		// try to initialize a new system locale
	    $locale = new TechDivision_Util_SystemLocale(
	        new TechDivision_Lang_String()
	    );
	    // let the test fail
		$this->fail(
		    'Initialize Locale with empty language only has to ' .
		    'throw a NullPointerException'
		);
	}

	/**
	 * This tests the constructor initialized with
	 * a empty language and a country.
	 *
	 * @return void
	 */
	public function testWithEmptyLanguageAndCountry()
	{
		// initialize a new Locale instance
		$locale = new TechDivision_Util_SystemLocale(
		    new TechDivision_Lang_String(),
		    new TechDivision_Lang_String("DE")
		);
		// check that the result equals "DE"
		$this->assertEquals("DE", $locale->getCountry()->stringValue());
		// check that the complete locale string equals "_DE"
		$this->assertEquals("_DE", $locale->toString()->stringValue());
	}

	/**
	 * This tests the constructor initialized with
	 * a empty language and a country and a variant.
	 *
	 * @return void
	 */
	public function testWithEmptyLanguageAndCountryAndVariant()
	{
		// initialize a new Locale instance
		$locale = new TechDivision_Util_SystemLocale(
		    new TechDivision_Lang_String(),
		    new TechDivision_Lang_String("DE"),
		    new TechDivision_Lang_String("Traditional_WIN")
		);
		// check that the result equals "DE"
		$this->assertEquals("DE", $locale->getCountry()->stringValue());
		// check that variant equals "Traditional_WIN"
		$this->assertEquals(
			"Traditional_WIN",
		    $locale->getVariant()->stringValue()
		);
		// check that the complete locale string equals "_DE_Traditional_WIN"
		$this->assertEquals(
			"_DE_Traditional_WIN",
		    $locale->toString()->stringValue()
		);
	}

	/**
	 * This tests the default system locale.
	 *
	 * @return void
	 */
	public function testDefaultLocale()
	{
		TechDivision_Util_SystemLocale::setDefault(
		    TechDivision_Util_SystemLocale::create(
		        TechDivision_Util_SystemLocale::US
		    )
		);
		$this->assertEquals(
		    TechDivision_Util_SystemLocale::US,
		    TechDivision_Util_SystemLocale::getDefault()->__toString()
		);
	}

	/**
	 * This tests the equal() method.
	 *
	 * @return void
	 */
	public function testEquals()
	{
	    // initialize a new US locale
	    $us = TechDivision_Util_SystemLocale::create(
	        TechDivision_Util_SystemLocale::US
	    );
        // initialize a second US locale to compare
	    $usToo = TechDivision_Util_SystemLocale::create(
	        TechDivision_Util_SystemLocale::US
	    );
        // intialize a new GERMANY locale to compare
	    $german = TechDivision_Util_SystemLocale::create(
	        TechDivision_Util_SystemLocale::GERMANY
	    );
        // compare the locales
		$this->assertFalse($us->equals($german));
		$this->assertTrue($us->equals($usToo));
	}
}