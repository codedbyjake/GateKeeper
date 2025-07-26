<?php

/*
use MediaWiki\SpecialPage\SpecialPage;
class SpecialGateKeeper extends SpecialPage {
*/
class SpecialGateKeeper extends \SpecialPage {

	public function __construct() {
	parent::__construct( 'GateKeeper', 'gatekeeper-manage' );
	}

	public function execute( $par ) {
	$this->setHeaders();
	$user = $this->getUser();

	/*
	
	Permissions testing
	
	if ( !$this->getUser()->isAllowed( 'gatekeeper-manage' ) ) {
    throw new PermissionsError( 'gatekeeper-manage', [ 'gatekeeper-denied' ] );
	}
	*/
	
	$output = $this->getOutput();
	$username = htmlspecialchars( $user->getName() );

	$output->addHTML( <<<HTML
<div style="max-width: 100%; margin: 2em auto; padding: 2em; background: #fdfdfd; border-radius: 8px; font-family: sans-serif;">
	<h1 style="margin-top: 0; font-size: 2em; color: #4B1D78; border-bottom: 1px solid #eee; padding-bottom: 0.3em;">
		GateKeeper
	</h1>
	<p style="font-size: 1.1em;">Hello, <strong>$username</strong></p>

	<!--<div style="margin-top: 1.5em;">
		<p style="margin-bottom: 0.5em;">Coming soon:</p>
		<ul style="padding-left: 1.2em;">
			<li>Feature 1</li>
			<li>Feature 2</li>
			<li>Feature 3</li>
			<li>Feature 4</li>
		</ul>
	</div>-->
	
	<div style="display: flex; flex-wrap: wrap; gap: 1em; margin-top: 2em;">

	<!-- Box 1 -->
	<div style="flex: 1 1 250px; background: #f0f0f0; padding: 1em 1.5em; border-radius: 8px;">
		<h3 style="margin-top: 0; color: #4B1D78; font-size: 1.1em;">🛡️ Blocked Edits</h3>
		<p style="font-size: 1.6em; margin: 0;"><strong>0</strong></p>
		<p style="margin: 0; font-size: 0.9em; color: #555;">Last 24 hours</p>
	</div>

	<!-- Box 2 -->
	<div style="flex: 1 1 250px; background: #f0f0f0; padding: 1em 1.5em; border-radius: 8px;">
		<h3 style="margin-top: 0; color: #4B1D78; font-size: 1.1em;">🔗 Link Filter Hits</h3>
		<p style="font-size: 1.6em; margin: 0;"><strong>0</strong></p>
		<p style="margin: 0; font-size: 0.9em; color: #555;">Placeholder text</p>
	</div>

	<!-- Box 3 -->
	<div style="flex: 1 1 250px; background: #f0f0f0; padding: 1em 1.5em; border-radius: 8px;">
		<h3 style="margin-top: 0; color: #4B1D78; font-size: 1.1em;">📁 Feature</h3>
		<p style="font-size: 1.6em; margin: 0;"><strong>0</strong></p>
		<p style="margin: 0; font-size: 0.9em; color: #555;">Placeholder text</p>
	</div>

	<!-- Box 4 -->
	<div style="flex: 1 1 250px; background: #f0f0f0; padding: 1em 1.5em; border-radius: 8px;">
		<h3 style="margin-top: 0; color: #4B1D78; font-size: 1.1em;">📅 Feature</h3>
		<p style="font-size: 1.6em; margin: 0;"><strong>–</strong></p>
		<p style="margin: 0; font-size: 0.9em; color: #555;">Placeholder text</p>
	</div>

	<!-- Box 5 -->
	<div style="flex: 1 1 250px; background: #f0f0f0; padding: 1em 1.5em; border-radius: 8px;">
		<h3 style="margin-top: 0; color: #4B1D78; font-size: 1.1em;">🚨 Feature</h3>
		<p style="font-size: 1.6em; margin: 0;"><strong>0</strong></p>
		<p style="margin: 0; font-size: 0.9em; color: #555;">Placeholder text</p>
	</div>

	<!-- Box 6 -->
	<div style="flex: 1 1 250px; background: #f0f0f0; padding: 1em 1.5em; border-radius: 8px;">
		<h3 style="margin-top: 0; color: #4B1D78; font-size: 1.1em;">💡 Feature</h3>
		<p style="font-size: 1.6em; margin: 0;"><strong>Off</strong></p>
		<p style="margin: 0; font-size: 0.9em; color: #555;">Placeholder text</p>
	</div>
</div>

<div style="margin-top: 3em; max-width: 900px; padding:0.5em;">
	<h2 style="color: #4B1D78; border-bottom: 1px solid #ddd; padding-bottom: 0.3em;">GateKeeper Configuration</h2>

	<form method="post" action="">
		<table style="width: 100%; border-collapse: collapse; margin-top: 1em; font-size: 0.95em;">
			<tbody>

				<tr style="border-bottom: 1px solid #eee;">
					<td style="padding: 0.6em;"><label for="blockLinks"><strong>Block links from new users</strong></label></td>
					<td style="padding: 0.6em;">
						<select name="blockLinks" id="blockLinks" style="padding: 0.3em; width: 150px;">
							<option value="1" selected>Enabled</option>
							<option value="0">Disabled</option>
						</select>
					</td>
				</tr>

				<tr style="border-bottom: 1px solid #eee;">
					<td style="padding: 0.6em;"><label for="minEdits"><strong>Minimum edits to post links</strong></label></td>
					<td style="padding: 0.6em;">
						<input type="number" name="minEdits" id="minEdits" value="5" min="0" style="width: 80px; padding: 0.3em;" />
					</td>
				</tr>

				<tr style="border-bottom: 1px solid #eee;">
					<td style="padding: 0.6em;"><label for="whitelist"><strong>Whitelisted domains</strong></label></td>
					<td style="padding: 0.6em;">
						<textarea name="whitelist" id="whitelist" rows="3" style="width: 100%; padding: 0.4em;" placeholder="One domain per line...">wikipedia.org
archive.org</textarea>
					</td>
				</tr>
				
				<tr style="border-bottom: 1px solid #eee;">
	<td style="padding: 0.6em; vertical-align: top;">
		<label for="blacklist"><strong>Blacklisted Keywords</strong></label><br>
		<small style="color: #666;">One per line. Case-insensitive match.</small>
	</td>
	<td style="padding: 0.6em;">
		<textarea name="blacklist" id="blacklist" rows="5" style="width: 100%; padding: 0.4em;" placeholder="e.g. cheap, viagra, free money">cheap
viagra
free money</textarea>
	</td>
</tr>


				<tr style="border-bottom: 1px solid #eee;">
					<td style="padding: 0.6em;"><label for="debugLog"><strong>Enable GateKeeper debug log</strong></label></td>
					<td style="padding: 0.6em;">
						<select name="debugLog" id="debugLog" style="padding: 0.3em; width: 150px;">
							<option value="1">Enabled</option>
							<option value="0" selected>Disabled</option>
						</select>
					</td>
				</tr>
				
				<tr style="border-bottom: 1px solid #eee;">
	<td style="padding: 0.6em;"><label for="devMode"><strong>Enable Developer Mode</strong></label></td>
	<td style="padding: 0.6em;">
		<select name="devMode" id="devMode" style="padding: 0.3em; width: 150px;">
			<option value="1">Enabled</option>
			<option value="0" selected>Disabled</option>
		</select>
	</td>
</tr>

<div id="gatekeeper-dev-panel" style="display: none; margin-top: 2em; padding: 1em; padding-top:0px; background: #fafafa; border: 1px dashed #ccc;">
	<h3 style="color: #4B1D78;">Developer Panel</h3>
	<p style="font-size: 0.95em;">This panel is visible when Developer Mode is enabled.</p>
	<ul style="font-size: 0.9em;">
	# Panel Content
	</ul>
</div>

				
				<tr style="border-bottom: 1px solid #eee;">
	<td style="padding: 0.6em;"><label for="accessGroup"><strong>Allowed Access Group</strong></label></td>
	<td style="padding: 0.6em;">
		<select name="accessGroup" id="accessGroup" style="padding: 0.3em; width: 200px;">
			<option value="sysop" selected>sysop (default)</option>
			<option value="administrator">administrator</option>
			<option value="bureaucrat">bureaucrat</option>
			<option value="user">user</option>
			<option value="*">All users</option>
		</select>
	</td>
</tr>

				
				

			</tbody>
		</table>

		<div style="margin-top: 1.5em;">
			<button type="submit" style="padding: 0.5em 1.2em; background: #4B1D78; color: #fff; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">
				💾 Save Changes
			</button>
		</div>
	</form>
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
	
$logPath = __DIR__ . '/../gatekeeper.log';
$logLines = [];

if ( file_exists( $logPath ) ) {
	$logLines = array_slice(
		file( $logPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES ),
		-25
	);
	$logLines = array_reverse( $logLines );
}

$logHTML = '<div style="max-width: 1000px; padding: 0.5em 2em;">
<h2 style="color: #4B1D78; border-bottom: 1px solid #ddd; padding-bottom: 0.3em;">GateKeeper Logs</h2>';

if ( empty( $logLines ) ) {
	$logHTML .= '<p style="color: #777;">No log entries found.</p>';
} else {
	$logHTML .= '<table style="width: 100%; border-collapse: collapse; font-size: 0.9em; margin-top: 1em;">
	<thead>
	<tr style="background: #f0f0f0;">
		<th style="padding: 0.6em; text-align: left;">Timestamp</th>
		<th style="padding: 0.6em; text-align: left;">Message</th>
	</tr>
	</thead>
	<tbody>';

	foreach ( $logLines as $line ) {
		if ( preg_match( '/^(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}) \[.*?\] (.+)$/', $line, $matches ) ) {
			$timestamp = htmlspecialchars( $matches[1] );
			$message = htmlspecialchars( $matches[2] );
		} else {
			$timestamp = '—';
			$message = htmlspecialchars( $line );
		}

		$logHTML .= "<tr style='border-bottom: 1px solid #eee;'>
			<td style='padding: 0.5em; color: #555;'>$timestamp</td>
			<td style='padding: 0.5em;'>$message</td>
		</tr>";
	}

	$logHTML .= '</tbody></table>';
}

$logHTML .= '</div>';
$output->addHTML( $logHTML );

}

}
$wgHooks['UserLoadRights'][] = function ( $user, &$rights ) {
	if ( in_array( 'administrator', $user->getEffectiveGroups() ) ) {
		$rights[] = 'gatekeeper-manage';
	}
	return true;
};
?>
<script>
document.addEventListener("DOMContentLoaded", function () {
	const blockLinksSelect = document.getElementById("blockLinks");
	const minEditsInput = document.getElementById("minEdits");

	function toggleMinEditsState() {
		const enabled = blockLinksSelect.value === "1";
		minEditsInput.disabled = !enabled;
		minEditsInput.style.backgroundColor = enabled ? "" : "#eee";
	}

	// Initial state
	toggleMinEditsState();

	// On change
	blockLinksSelect.addEventListener("change", toggleMinEditsState);
});
// Toggle dev
document.addEventListener("DOMContentLoaded", function () {
	const devToggle = document.getElementById("devMode");
	const devPanel = document.getElementById("gatekeeper-dev-panel");

	function toggleDevPanel() {
		devPanel.style.display = devToggle.value === "1" ? "block" : "none";
	}

	if (devToggle) {
		devToggle.addEventListener("change", toggleDevPanel);
		toggleDevPanel();
	}
});
</script>
