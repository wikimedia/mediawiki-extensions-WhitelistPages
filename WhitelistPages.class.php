<?php
/**
 * A quick hack to make $wgWhitelistRead an admin-editable system message.
 *
 * @file
 * @ingroup Extensions
 * @author Jack Phoenix <jack@shoutwiki.com>
 * @author Misza <misza@shoutwiki.com>
 * @date 19 November 2015
 * @license https://en.wikipedia.org/wiki/Public_domain Public domain
 */

class WhitelistPages {

	public static function main() {
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

}