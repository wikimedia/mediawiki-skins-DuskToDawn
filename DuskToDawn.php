<?php
/**
 * MediaWiki port of the WordPress theme Dusk To Dawn
 *
 * @file
 * @ingroup Skins
 * @author Automattic
 * @author Jack Phoenix <jack@countervandalism.net> -- MediaWiki port
 * @date 30 November 2014
 * @see http://theme.wordpress.com/themes/dusk-to-dawn/
 * @see http://wp-themes.com/dusk-to-dawn/
 *
 * To install, place the DuskToDawn folder (the folder containing this file!) into
 * skins/ and add this line to your wiki's LocalSettings.php:
 * wfLoadSkin( 'DuskToDawn' );
 */

if ( function_exists( 'wfLoadSkin' ) ) {
	wfLoadSkin( 'DuskToDawn' );
	// Keep i18n globals so mergeMessageFileList.php doesn't break
	$wgMessagesDirs['DuskToDawn'] = __DIR__ . '/i18n';
	wfWarn(
		'Deprecated PHP entry point used for DuskToDawn skin. Please use wfLoadSkin instead, ' .
		'see https://www.mediawiki.org/wiki/Extension_registration for more details.'
	);
	return;
} else {
	die( 'This version of the DuskToDawn skin requires MediaWiki 1.25+' );
}
