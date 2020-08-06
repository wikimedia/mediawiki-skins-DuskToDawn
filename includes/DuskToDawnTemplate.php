<?php
/**
 * MediaWiki port of the WordPress theme Dusk To Dawn
 *
 * @file
 * @author Automattic
 * @author Jack Phoenix -- MediaWiki port
 * @see http://theme.wordpress.com/themes/dusk-to-dawn/
 * @see http://wp-themes.com/dusk-to-dawn/
 */

class DuskToDawnTemplate extends BaseTemplate {

	/**
	 * "Page last edited X days Y hours ago" feature for content namespaces
	 * Almost verbatim copypasta from Aurora (/skins/Aurora/Aurora.skin.php)
	 */
	private function getLastEdited() {
		$title = $this->getSkin()->getTitle();
		$msg = '';

		if ( $title->exists() && $title->isContentPage() ) {
			// First construct a Revision object from the current Title...
			$page = Wikipage::factory( $title );
			// ...then get its timestamp...
			$timestamp = $page->getTimestamp();
			// ...turn it into a UNIX timestamp...
			$unixTS = wfTimestamp( TS_UNIX, $timestamp );
			// ..and pass everything to MediaWiki's crazy formatter
			// function.
			$formattedTS = $this->getSkin()->getLanguage()->formatTimePeriod(
				time() - $unixTS,
				[
					'noabbrevs' => true,
					// There doesn't appear to be an 'avoidhours'; if there
					// were, we'd use it so that this'd match the mockup.
					'avoid' => 'avoidminutes'
				]
			);

			// Get the last editor's username (if any), too
			$author = $page->getUserText();

			// Pick the correct internationalization message, depending on if
			// the current user is allowed to access the revision's last author's
			// name or not (hey, it could be RevisionDeleted, as Revision::getUserText()'s
			// documentation states)
			if ( $author ) {
				$msg = wfMessage( 'dusktodawn-page-edited-user', $formattedTS, $author )->parse();
			} else {
				$msg = wfMessage( 'dusktodawn-page-edited', $formattedTS )->parse();
			}
		}

		return $msg;
	}

	/**
	 * Template filter callback for the Dusk To Dawn skin.
	 * Takes an associative array of data set from a SkinTemplate-based
	 * class, and a wrapper for MediaWiki's localization database, and
	 * outputs a formatted page.
	 */
	public function execute() {
		global $wgSitename;

		$this->data['pageLanguage'] = $this->getSkin()->getTitle()->getPageViewLanguage()->getHtmlCode();

		$this->html( 'headelement' );
?>
<div id="super-super-wrapper">
	<div id="super-wrapper">
		<div id="wrapper">
			<div id="page" class="hfeed">
				<header id="branding" role="banner">
					<div>
						<h1 class="firstHeading"><span dir="auto"><?php echo Html::element( 'a', [
							'href' => $this->data['nav_urls']['mainpage']['href'] ]
							+ Linker::tooltipAndAccesskeyAttribs( 'p-logo' ), $wgSitename ); ?></span></h1>
						<h2 id="site-description"><?php $this->msg( 'tagline' ) ?></h2>
					</div>
				</header><!-- #branding -->

				<div id="main" class="clear-fix">
					<div id="primary">
						<div id="content" class="mw-body-primary clear-fix" role="main">
							<?php if ( $this->data['sitenotice'] ) { ?><div id="siteNotice"><?php $this->html( 'sitenotice' ) ?></div><?php } ?>
							<article class="post hentry">
								<header class="entry-header">
									<div class="entry-meta noprint">
										<?php echo $this->getLastEdited(); ?>
									</div><!-- .entry-meta -->

									<h1 id="firstHeading" class="firstHeading entry-title" lang="<?php $this->text( 'pageLanguage' ); ?>"><?php $this->html( 'title' ) ?></h1>
									<?php if ( $this->data['undelete'] ) { ?><div id="contentSub2"><?php $this->html( 'undelete' ) ?></div><?php } ?>
								</header><!-- .entry-header -->

								<div id="jump-to-nav"></div>
								<a class="mw-jump-link" href="#secondary"><?php $this->msg( 'dusktodawn-jump-to-navigation' ) ?></a>
								<a class="mw-jump-link" href="#searchInput"><?php $this->msg( 'dusktodawn-jump-to-search' ) ?></a>
								<div class="entry-content mw-body-content">
									<?php if ( $this->data['newtalk'] ) { ?><div class="usermessage"><?php $this->html( 'newtalk' ) ?></div><?php } ?>
									<!-- start content -->
									<?php
										$this->html( 'bodytext' );
										if ( $this->data['catlinks'] ) {
											$this->html( 'catlinks' );
										}
									?>
									<!-- end content -->
									<?php
										if ( $this->data['dataAfterContent'] ) {
											$this->html( 'dataAfterContent' );
										}
									?>
								</div><!-- .entry-content -->
							</article><!-- #post-## -->

							<nav id="nav-below" class="clear-fix noprint">
								<h1 class="assistive-text section-heading"><?php $this->msg( 'navigation' ) ?></h1>
							</nav><!-- #nav-below -->

						</div><!-- #content -->
					</div><!-- #primary -->

					<div id="secondary" class="widget-area noprint" role="complementary">
					<?php $this->renderPersonalTools(); ?>
					<?php $this->cactions(); ?>
					<?php $this->renderPortals( $this->data['sidebar'] ); ?>
					</div><!-- #secondary .widget-area -->
				</div><!-- #main -->
			</div><!-- #page -->

			<?php
				$validFooterIcons = $this->getFooterIcons( 'icononly' );
				$validFooterLinks = $this->getFooterLinks( 'flat' ); // Additional footer links

				if ( count( $validFooterIcons ) + count( $validFooterLinks ) > 0 ) { ?>
<footer id="colophon" role="contentinfo"<?php $this->html( 'userlangattributes' ) ?>>
<?php
					$footerEnd = '</footer><!-- #colophon -->';
				} else {
					$footerEnd = '';
				}

				// @todo FIXME/CHECKME
				foreach ( $validFooterIcons as $blockName => $footerIcons ) { ?>
	<div id="f-<?php echo htmlspecialchars( $blockName ); ?>ico">
<?php
					foreach ( $footerIcons as $icon ) {
						echo $this->getSkin()->makeFooterIcon( $icon );
					}
?>
	</div>
<?php
				}

				$i = 0;
				$footerLen = count( $validFooterLinks );
				if ( $footerLen > 0 ) {
					echo '<div id="site-generator">';
					foreach ( $validFooterLinks as $aLink ) {
						$this->html( $aLink );
						// Output the separator for all items, save for the
						// last one
						if ( $i !== ( $footerLen - 1 ) ) {
							echo '<span class="sep"> | </span>';
						}
						$i++;
					}
					echo '</div><!-- #site-generator -->';
				}

				echo $footerEnd;
?>
		</div><!-- #wrapper -->
	</div><!-- #super-wrapper -->
</div><!-- #super-super-wrapper -->
<?php
		$this->printTrail();
		echo Html::closeElement( 'body' );
		echo Html::closeElement( 'html' );
	} // end of execute() method

	/**
	 * @param $sidebar array
	 */
	protected function renderPortals( $sidebar ) {
		if ( !isset( $sidebar['SEARCH'] ) ) {
			$sidebar['SEARCH'] = true;
		}
		if ( !isset( $sidebar['TOOLBOX'] ) ) {
			$sidebar['TOOLBOX'] = true;
		}
		if ( !isset( $sidebar['LANGUAGES'] ) ) {
			$sidebar['LANGUAGES'] = true;
		}

		foreach ( $sidebar as $boxName => $content ) {
			if ( $content === false ) {
				continue;
			}

			if ( $boxName == 'SEARCH' ) {
				$this->searchBox();
			} elseif ( $boxName == 'TOOLBOX' ) {
				$this->toolbox();
			} elseif ( $boxName == 'LANGUAGES' ) {
				$this->languageBox();
			} else {
				$this->customBox( $boxName, $content );
			}
		}
	}

	function renderPersonalTools() {
		$this->customBox( 'personal', $this->getPersonalTools() );
	}

	function searchBox() {
?>
						<aside id="search-3" class="widget widget_search">
							<form role="search" method="get" id="searchform" class="searchform" action="<?php $this->text( 'wgScript' ) ?>">
								<div>
									<label class="screen-reader-text" for="searchInput"><?php $this->msg( 'search' ) ?></label>
									<input type="hidden" name="title" value="<?php $this->text( 'searchtitle' ) ?>"/>
									<?php
										echo $this->makeSearchInput( [ 'id' => 'searchInput' ] );
										echo $this->makeSearchButton( 'go',
											[ 'id' => 'searchGoButton', 'class' => 'searchButton' ]
										);
										echo '&#160;';
										echo $this->makeSearchButton(
											'fulltext',
											[ 'id' => 'mw-searchButton', 'class' => 'searchButton' ]
										);
									?>
								</div>
							</form>
						</aside>
<?php
	}

	/**
	 * Prints the content actions bar.
	 */
	function cactions() {
?>
	<aside id="p-cactions" class="portlet widget" role="navigation">
		<h1 class="widget-title"><?php $this->msg( 'views' ) ?></h1>
			<ul><?php
				foreach ( $this->data['content_actions'] as $key => $tab ) {
					echo '
				' . $this->makeListItem( $key, $tab );
				} ?>
			</ul>
	</aside>
<?php
	}

	function toolbox() {
?>
	<aside class="portlet widget" id="p-tb" role="navigation">
		<h1 class="widget-title"><?php $this->msg( 'toolbox' ) ?></h1>
		<ul>
<?php
		foreach ( $this->getToolbox() as $key => $tbItem ) {
			echo $this->makeListItem( $key, $tbItem );
		}
		// Avoid PHP 7.1 warning of passing $this by reference
		$template = $this;
		Hooks::run( 'SkinTemplateToolboxEnd', [ &$template, true ] );
?>
		</ul>
	</aside>
<?php
	}

	function languageBox() {
		if ( $this->data['language_urls'] ) {
?>
	<aside id="p-lang" class="portlet widget" role="navigation">
		<h1 class="widget-title"<?php $this->html( 'userlangattributes' ) ?>><?php $this->msg( 'otherlanguages' ) ?></h1>
		<ul>
<?php		foreach ( $this->data['language_urls'] as $key => $langLink ) {
				echo $this->makeListItem( $key, $langLink );
			}
?>
		</ul>
	</aside>
<?php
		}
	}

	/**
	 * Render a sidebar box from user-supplied data (a portion of MediaWiki:Sidebar)
	 *
	 * @param $bar string
	 * @param $cont array|string
	 */
	function customBox( $bar, $cont ) {
		$portletAttribs = [
			'class' => 'generated-sidebar widget',
			'id' => Sanitizer::escapeIdForAttribute( "p-$bar" ),
			'role' => 'navigation'
		];
		$tooltip = Linker::titleAttrib( "p-$bar" );
		if ( $tooltip !== false ) {
			$portletAttribs['title'] = $tooltip;
		}
		echo '	' . Html::openElement( 'aside', $portletAttribs );

		$msgObj = wfMessage( $bar );
?>

		<h1 class="widget-title"><?php echo htmlspecialchars( $msgObj->exists() ? $msgObj->text() : $bar ); ?></h1>
<?php	if ( is_array( $cont ) ) { ?>
			<ul>
<?php 			foreach ( $cont as $key => $val ) {
					echo $this->makeListItem( $key, $val );
				}
?>
			</ul>
<?php	} else {
			// allow raw HTML block to be defined by extensions (such as NewsBox)
			echo $cont;
		}
?>
	</aside>
<?php
	}
}
