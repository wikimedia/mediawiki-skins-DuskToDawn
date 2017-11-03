<?php

/**
 * Inherit main code from SkinTemplate, set the CSS and template filter.
 *
 * @ingroup Skins
 */
class SkinDuskToDawn extends SkinTemplate {
	public $skinname = 'dusktodawn', $stylename = 'dusktodawn',
		$template = 'DuskToDawnTemplate', $useHeadElement = true;

	/**
	 * @param $out OutputPage
	 */
	function setupSkinUserCss( OutputPage $out ) {
		global $wgStylePath;

		parent::setupSkinUserCss( $out );

		// Load CSS via ResourceLoader
		$out->addModuleStyles( array(
			'mediawiki.skinning.interface',
			'mediawiki.skinning.content.externallinks',
			'skins.dusktodawn'
		) );

		// And JS too!
		$out->addModuleScripts( 'skins.dusktodawn' );
	}
}