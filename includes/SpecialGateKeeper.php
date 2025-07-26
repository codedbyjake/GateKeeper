<?php

/*
use MediaWiki\SpecialPage\SpecialPage;
class SpecialGateKeeper extends SpecialPage {
*/
class SpecialGateKeeper extends \SpecialPage {

	public function __construct() {
		parent::__construct( 'GateKeeper' );
	}

	public function execute( $par ) {
	$this->setHeaders();
	$output = $this->getOutput();
	$user = $this->getUser();

	$username = htmlspecialchars( $user->getName() );

	$output->addHTML( <<<HTML
<div style="max-width: 100%; margin: 2em auto; padding: 2em; background: #fdfdfd; border-radius: 8px; font-family: sans-serif;">
	<h1 style="margin-top: 0; font-size: 2em; color: #4B1D78; border-bottom: 1px solid #eee; padding-bottom: 0.3em;">
		GateKeeper
	</h1>
	<p style="font-size: 1.1em;">Hello, <strong>$username</strong></p>

	<div style="margin-top: 1.5em;">
		<p style="margin-bottom: 0.5em;">Coming soon:</p>
		<ul style="padding-left: 1.2em;">
			<li>Feature 1</li>
			<li>Feature 2</li>
			<li>Feature 3</li>
			<li>Feature 4</li>
		</ul>
	</div>

	<div style="margin-top: 2em; font-size: 0.95em; color: #666;">
	<p>
		This special page is part of the <strong>GateKeeper</strong> extension.
		More features will appear as the system evolves.
		<br>
		<a href="https://github.com/codedbyjake/GateKeeper" target="_blank" rel="noopener" style="color: #4B1D78; text-decoration: none;">
			View the GitHub repository →
		</a>
	</p>
	</div>
</div>
HTML
	);
}

}