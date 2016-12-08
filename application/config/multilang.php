<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Multilang module config file
 */
	if(Kohana::$config->load('lang.hide_default') == 1) $hide = TRUE;
	else $hide = FALSE;
	
	if(Kohana::$config->load('lang.auto_detect') == 1) $detect = TRUE;
	else $detect = FALSE;

	$lang = array();
		
	$mlangs = ORM::factory('Lang')->find_all()->as_array();
		
	foreach ($mlangs as $mlang)
	{
		$id = $mlang->i18n;

        $lang[$id ] = array(
                       'i18n'   => $mlang->i18n,
                       'locale' => $mlang->locale,
                       'label'  => $mlang->label
        );
	}

 
return array(

	'default'		=> Kohana::$config->load('lang.default'), // The default language code
	'cookie'		=> Kohana::$config->load('lang.cookie'), // The cookie name
	'hide_default'	=> $hide, // You can hide the language code for the default language
	'auto_detect'	=> $detect, // Auto detect the user language on the homepage
	
	/**
	 * The allowed languages
	 * For each language, you need to give a code (2-5 chars) for the key,
	 * the 5 letters i18n language code, the locale and the label for the auto generated language selector menu.
	 */
	
	'languages'		=>	$lang,
	
);

