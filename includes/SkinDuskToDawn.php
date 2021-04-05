<?php

/**
 * Inherit main code from SkinTemplate, set the CSS and template filter.
 *
 * @ingroup Skins
 */
class SkinDuskToDawn extends SkinTemplate {
	public $skinname = 'dusktodawn', $stylename = 'dusktodawn',
		$template = 'DuskToDawnTemplate';

	/**
	 * @param OutputPage $out
	 */
	public function initPage( OutputPage $out ) {
		parent::initPage( $out );

		$out->addModules( 'skins.dusktodawn.audio' );
	}
}
