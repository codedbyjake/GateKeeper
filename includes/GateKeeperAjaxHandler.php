<?php

use MediaWiki\MediaWikiServices;

$wgAjaxExportList[] = 'GateKeeperAjaxSave';

function GateKeeperAjaxSave() {
	$request = RequestContext::getMain()->getRequest();

	$config = [
		'blockLinks' => (string)$request->getVal('blockLinks'),
		'minEdits' => (string)$request->getVal('minEdits'),
		'whitelist' => $request->getText('whitelist'),
		'blacklist' => $request->getText('blacklist'),
		'debugLog' => (string)$request->getVal('debugLog'),
		'devMode' => (string)$request->getVal('devMode'),
		'accessGroup' => $request->getVal('accessGroup'),
	];

	$configFile = __DIR__ . '/../gatekeeper-config.json';

	$success = file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

	if ( $success !== false ) {
		header( 'Content-Type: application/json' );
		echo json_encode( [ 'status' => 'success' ] );
	} else {
		header( 'Content-Type: application/json' );
		echo json_encode( [ 'status' => 'error', 'message' => 'Unable to write config file' ] );
	}
	die;
}