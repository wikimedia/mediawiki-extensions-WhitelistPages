<?php

use MediaWiki\Title\Title;

/**
 * A quick hack to make $wgWhitelistRead an admin-editable system message.
 *
 * @author Jack Phoenix <jack@shoutwiki.com>
 * @author Misza <misza@shoutwiki.com>
 * @license https://en.wikipedia.org/wiki/Public_domain Public domain
 */
class WhitelistPages {

	/**
	 * @param Title $title Title object being checked against
	 * @param User $user Current user object
	 * @param bool &$whitelisted Whether this title is whitelisted
	 * @return void
	 */
	public static function onTitleReadWhitelist( $title, $user, &$whitelisted ) {
		global $wgGroupPermissions;

		$message = wfMessage( 'public_read_whitelist' )->inContentLanguage();

		// If [[MediaWiki:Public read whitelist]] is empty, bail out
		if ( $message->isDisabled() ) {
			return;
		}

		// If anonymous users can read the wiki, then it's not a private one
		// and we don't need this feature for non-private wikis
		if ( $wgGroupPermissions['*']['read'] ) {
			return;
		}

		static $whitelistedPages;
		if ( $whitelistedPages === null ) {
			// Explode along newlines
			$whitelistedPages = explode( "\n", trim( $message->plain() ) );
		}
		if ( in_array( $title->getPrefixedText(), $whitelistedPages ) ) {
			$whitelisted = true;
		}
	}

}
