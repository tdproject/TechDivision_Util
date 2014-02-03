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

require_once 'TechDivision/Lang/String.php';
require_once 'TechDivision/Lang/Exceptions/NullPointerException.php';
require_once 'TechDivision/Collections/Interfaces/Predicate.php';
require_once 'TechDivision/Collections/CollectionUtils.php';
require_once 'TechDivision/Collections/ArrayList.php';
require_once 'TechDivision/Util/Predicates/SystemLocaleExists.php';

/**
 * A Locale object represents a specific geographical, political, or cultural
 * region. An operation that requires a Locale to perform its task is called
 * locale-sensitive and uses the Locale  to tailor information for the user.
 * For example, displaying a number is a locale-sensitive operation--the number
 * should be formatted according to the customs/conventions of the user's native
 * country, region, or culture.
 *
 * The language argument is a valid ISO Language Code. These codes are the
 * lower-case, two-letter codes as defined by ISO-639. You can find a full list
 * of these codes at a number of sites, such as:
 * http://www.ics.uci.edu/pub/ietf/http/related/iso639.txt
 *
 * The country argument is a valid ISO Country Code. These codes are the
 * upper-case, two-letter codes as defined by ISO-3166. You can find a full list
 * of these codes at a number of sites, such as:
 * http://www.chemie.fu-berlin.de/diverse/doc/ISO_3166.html
 *
 * The variant argument is a vendor or browser-specific code. For example, use
 * WIN for Windows, MAC for Macintosh, and POSIX for POSIX. Where there are two
 * variants, separate them with an underscore, and put the most important one
 * first. For example, a Traditional Spanish collation might construct a locale
 * with parameters for language, country and variant as: "es", "ES",
 * "Traditional_WIN".
 *
 * Because a Locale object is just an identifier for a region, no validity check
 * is performed when you construct a Locale. If you want to see whether
 * particular resources are available for the Locale you construct, you must
 * query those resources. For example, ask the NumberFormat for the locales it
 * supports using its getAvailableLocales method.
 *
 * Note: When you ask for a resource for a particular locale, you get back the
 * best available match, not necessarily precisely what you asked for. For more
 * information, look at ResourceBundle.
 *
 * The Locale class provides a number of convenient constants that you can use
 * to create Locale objects for commonly used locales. For example, the
 * following creates a Locale object for the United States:
 *
 * SystemLocale::create(SystemLocale::US)
 *
 * Once you've created a Locale you can query it for information about itself.
 * Use getCountry to get the ISO Country Code and getLanguage to get the ISO
 * Language Code. You can use getDisplayCountry to get the name of the country
 * suitable for displaying to the user. Similarly, you can use
 * getDisplayLanguage to get the name of the language suitable for displaying
 * to the user. Interestingly, the getDisplayXXX methods are themselves
 * locale-sensitive and have two versions: one that uses the default locale and
 * one that uses the locale specified as an argument.
 *
 * @package TechDivision_Util
 * @author Tim Wagner <t.wagner@techdivision.com>
 * @copyright TechDivision GmbH
 * @link http://www.techdivision.com
 * @license GPL
 */
class TechDivision_Util_SystemLocale extends TechDivision_Lang_Object
{

	/**
	 * Holds the constant for the United States locale string.
	 * @var string
	 */
	const US = 'en_US';

	/**
	 * Holds the constant for the United Kingdom locale string.
	 * @var string
	 */
	const UK = 'en_UK';

	/**
	 * Holds the constant for the Germany locale string.
	 * @var string
	 */
	const GERMANY = 'de_DE';

	/**
	 * Holds the language.
	 * @var TechDivision_Lang_String
	 */
	private $_language = null;

	/**
	 * Holds the country.
	 * @var TechDivision_Lang_String
	 */
	private $_country = null;

	/**
	 * Holds the variant.
	 * @var TechDivision_Lang_String
	 */
	private $_variant = null;

	/**
	 * Construct a locale from language, country, variant. NOTE: ISO 639 is not
	 * a stable standard; some of the language codes it defines (specifically
	 * iw, ji, and in) have changed. This constructor accepts both the old codes
	 * (iw, ji, and in) and the new codes (he, yi, and id), but all other API on
	 * Locale will return only the OLD codes.
	 *
	 * @param TechDivision_Lang_String $language
	 * 		The lowercase two-letter ISO-639 code
	 * @param TechDivision_Lang_String $country
	 * 		The uppercase two-letter ISO-3166 code
	 * @param TechDivision_Lang_String $variant
	 * 		The vendor and browser specific code. See class description.
	 * @return TechDivision_Lang_NullPointerExcecption
	 * 		Is thrown if neither the passed language or counter are empty
	 */
	public function __construct(
	    TechDivision_Lang_String $language,
	    TechDivision_Lang_String $country = null,
	    TechDivision_Lang_String $variant = null) {
		// initialize the language
		$this->_language = $language;
		// initialize the country and the variant with the passed values
		$this->_country = new TechDivision_Lang_String($country);
		$this->_variant = new TechDivision_Lang_String($variant);
		// initialize the country and check if at least a language
		// or a country is passed
		if ($this->_language->length() == 0 &&
		    $this->_country->length() == 0) {
			throw new TechDivision_Lang_Exceptions_NullPointerException(
				'Either language or country must have a value'
			);
		}
	}

	/**
	 * This method tries to create a new Locale instance from
	 * the passed string value.
	 *
	 * The passed string must have the following format: language_country
	 *
	 * @param string $localeString
	 * 		Holds the locale string to create the locale from
	 * @return TechDivision_Util_SystemLocale
	 * 		Holds the initialized locale object
	 */
	public static function create($localeString)
	{
		// split the passed string
		$elements = new TechDivision_Collections_ArrayList(
		    explode("_", $localeString)
		);
		// if only the language was found
		if ($elements->size() == 1) {
			// initialize a new Locale
			return new TechDivision_Util_SystemLocale(
			    new TechDivision_Lang_String($elements->get(0))
			  );
		}
		// if the language and the country was found
		if ($elements->size() == 2) {
			// initialize a new Locale
			return new TechDivision_Util_SystemLocale(
			    new TechDivision_Lang_String($elements->get(0)),
			    new TechDivision_Lang_String($elements->get(1))
			);
		}
		// if the language, the country and the variant was found
		if ($elements->size() == 3) {
			// initialize a new Locale
			return new TechDivision_Util_SystemLocale(
			    new TechDivision_Lang_String($elements->get(0)),
			    new TechDivision_Lang_String($elements->get(1)),
			    new TechDivision_Lang_String($elements->get(2)));
		}
	}

	/**
	 * This method returns an ArrayList with the installed
	 * system locales.
	 *
	 * @return TechDivision_Collections_ArrayList
	 * 		Holds an ArrayList with Locale instances installed
	 * 		on the actual system
	 */
	public static function getAvailableLocales()
	{
		// initialize the ArrayList for the system locales
		$locales = new TechDivision_Collections_ArrayList();
		// initialize the result array
		$result = array();
		// get the list with locales
	    exec('locale -a', $result);
	    // initialize the Locale instances and add them the ArrayList
	    foreach($result as $locale) {
	        // initialize the array with the found locales
	    	$locales->add(
	    	    TechDivision_Util_SystemLocale::create(trim($locale))
	    	);
	    }
	    // return the locales
	    return $locales;
	}

	/**
	 * Getter for the programmatic name of the entire locale, with
	 * the language, country and variant separated by underbars.
	 *
	 * @return TechDivision_Lang_String Holds the entire locale as String object
	 * @see TechDivision_Util_SystemLocale::__toString()
	 */
	public function toString()
	{
		return new TechDivision_Lang_String($this->__toString());
	}

	/**
	 * Getter for the programmatic name of the entire locale, with
	 * the language, country and variant separated by underbars.
	 *
	 * @return string Holds the entire locale as string
	 * @see TechDivision_Util_SystemLocale::toString()
	 */
	public function __toString()
	{
		$string = '';
		if (!$this->_language->length() == 0) {
			$string = $this->_language->stringValue();
		}
		if (!$this->_country->length() == 0) {
			$string .= "_" . $this->_country->stringValue();
		}
		if (!$this->_variant->length() == 0) {
			$string .= "_" . $this->_variant->stringValue();
		}
		return $string;
	}

	/**
	 * Sets the default locale, but does not set
	 * the system locale.
	 *
	 * @param TechDivision_Util_SystemLocale $newLocale
	 * 		Holds the new default system locale to use
	 * @throws Exception
	 * 		Is thrown if the passed locale is not installed in the system
	 * @return void
	 */
	public static function setDefault(TechDivision_Util_SystemLocale $newLocale)
    {
		// check if the passed locale is installed
		if (!TechDivision_Collections_CollectionUtils::exists(
		    TechDivision_Util_SystemLocale::getAvailableLocales(),
		    new TechDivision_Util_Predicates_SystemLocaleExists($newLocale))) {
			throw new Exception(
				'System locale ' . $newLocale . ' is not installed'
			);
		}
		// set the default system locale
		if (!setlocale(LC_ALL, $newLocale)) {
			throw new Exception(
				'Default locale can\'t be set to ' . $newLocale
			);
		}
	}

	/**
	 * Returns the default system locale.
	 *
	 * @return TechDivision_Util_SystemLocale Holds the default system locale
	 * @throws Exception if no system locale is set
	 */
	public static function getDefault()
	{
        // initialize the variables
	    $language = new TechDivision_Lang_String();
	    $country = new TechDivision_Lang_String();
	    $variant = new TechDivision_Lang_String();
		// get the default system locale
		$systemLocale = setlocale(LC_ALL, "0");
		// explode the parts
		$list = new TechDivision_Collections_ArrayList(
		    explode("_", $systemLocale)
		);
		// initialize the language, the country and the variant
		if ($list->size() > 0) {
			if ($list->exists(0)) {
				$language = new TechDivision_Lang_String($list->get(0));
			}
			if ($list->exists(1)) {
				$country = new TechDivision_Lang_String($list->get(1));
			}
			if ($list->exists(2)) {
				$variant = new TechDivision_Lang_String($list->get(2));
			}
		} else {
			throw new Exception("No system locale set");
		}
		// initialize and return the SystemLocale instance
		return new TechDivision_Util_SystemLocale(
		    $language,
		    $country,
		    $variant
		);
	}

	/**
	 * Returns the language.
	 *
	 * @return String Holds the language
	 */
	public function getLanguage()
	{
		return $this->_language;
	}

	/**
	 * Returns the country.
	 *
	 * @return String Holds the country
	 */
	public function getCountry()
	{
		return $this->_country;
	}

	/**
	 * Returns the variant.
	 *
	 * @return String Holds the variant
	 */
	public function getVariant()
	{
		return $this->_variant;
	}

	/**
	 * Returns true if the passed value is equal.
	 *
	 * @param TechDivision_Lang_Object $val The value to check
	 * @return boolean
	 */
	public function equals(TechDivision_Lang_Object $val)
	{
		return $this->__toString() == $val->__toString();
	}
}