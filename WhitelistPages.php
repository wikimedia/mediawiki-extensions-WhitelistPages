<?php
/**
 * A quick hack to make $wgWhitelistRead an admin-editable system message.
 *
 * @file
 * @ingroup Extensions
 * @author Jack Phoenix <jack@shoutwiki.com>
 * @author Misza <misza@shoutwiki.com>
 * @date 26 January 2011
 * @see http://en.gwo.shoutwiki.com/w/index.php?title=User_talk%3AJack_Phoenix&diff=302&oldid=83
 * @license http://en.wikipedia.org/wiki/Public_domain Public domain
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This is not a valid entry point to MediaWiki.' );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Whitelist Pages',
	'author' => array( 'Jack Phoenix', 'Misza' ),
	'version' => '0.3.0',
	'descriptionmsg' => 'whitelistpages-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Whitelist_Pages',
);

$wgMessagesDirs['WhitelistPages'] = __DIR__ . '/i18n';
$wgExtensionMessagesFiles['WhitelistPages'] = dirname( __FILE__ ) . '/WhitelistPages.i18n.php';

$wgExtensionFunctions[] = 'wfWhitelistPages';
function wfWhitelistPages() {
	global $wgWhitelistRead, $wgGroupPermissions;

	$message = wfMessage( 'public_read_whitelist' )->inContentLanguage();

	// If MediaWiki:Public read whitelist is empty, bail out
	if ( $message->isDisabled() ) {
		return;
	}

	// If anonymous users can read the wiki, then it's not a private one
	// and we don't need this feature for non-private wikis
	if ( $wgGroupPermissions['*']['read'] ) {
		return;
	}

	// $wgWhitelistRead is *false* by default instead of being an empty array
	if ( $wgWhitelistRead === false ) {
		$wgWhitelistRead = array();
	}

	// Explode along newlines
	$whitelistedPages = explode( "\n", trim( $message->plain() ) );

	// Merge with current list
	$wgWhitelistRead = array_merge( $wgWhitelistRead, $whitelistedPages );
}
