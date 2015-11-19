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

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Whitelist Pages',
	'author' => array( 'Jack Phoenix', 'Misza' ),
	'version' => '0.4.0',
	'descriptionmsg' => 'whitelistpages-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Whitelist_Pages',
);

$wgMessagesDirs['WhitelistPages'] = __DIR__ . '/i18n';

$wgAutoloadClasses['WhitelistPages'] = __DIR__ . '/WhitelistPages.class.php';

$wgExtensionFunctions[] = 'WhitelistPages::main';
