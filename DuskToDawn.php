<?php
/**
 * MediaWiki port of the WordPress theme Dusk To Dawn
 *
 * @file
 * @ingroup Skins
 * @author Automattic
 * @author Jack Phoenix <jack@countervandalism.net> -- MediaWiki port
 * @date 9 February 2014
 * @see http://theme.wordpress.com/themes/dusk-to-dawn/
 * @see http://wp-themes.com/dusk-to-dawn/
 *
 * To install, place the DuskToDawn folder (the folder containing this file!) into
 * skins/ and add this line to your wiki's LocalSettings.php:
 * require_once("$IP/skins/DuskToDawn/DuskToDawn.php");
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not a valid entry point.' );
}

// Skin credits that will show up on Special:Version
$wgExtensionCredits['skin'][] = array(
	'path' => __FILE__,
	'name' => 'Dusk To Dawn',
	'version' => '1.3',
	'author' => array( '[http://automattic.com/ Automattic]', 'Jack Phoenix' ),
	'description' => 'A dark theme that melds old-style organic ornaments with modern design and typography',
	'url' => 'https://www.mediawiki.org/wiki/Skin:DuskToDawn',
);

// The first instance must be strtolower()ed so that useskin=dusktodawn works and
// so that it does *not* force an initial capital (i.e. we do NOT want
// useskin=Dusktodawn) and the second instance is used to determine the name of
// *this* file.
$wgValidSkinNames['dusktodawn'] = 'DuskToDawn';

// Autoload the skin class, make it a valid skin, set up i18n, set up CSS & JS
// (via ResourceLoader)
$wgAutoloadClasses['SkinDuskToDawn'] = __DIR__ . '/DuskToDawn.skin.php';
$wgMessagesDirs['SkinDuskToDawn'] = __DIR__ . '/i18n';
$wgResourceModules['skins.dusktodawn'] = array(
	'styles' => array(
		// MonoBook also loads these
		'skins/common/commonElements.css' => array( 'media' => 'screen' ),
		'skins/common/commonContent.css' => array( 'media' => 'screen' ),
		'skins/common/commonInterface.css' => array( 'media' => 'screen' ),
		// Styles custom to the DuskToDawn skin
		'skins/DuskToDawn/resources/style.css' => array( 'media' => 'screen' )
	),
	'scripts' => array(
		'/skins/DuskToDawn/resources/js/audio.js'
	),
	'position' => 'top'
);