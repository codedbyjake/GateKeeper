# GateKeeper
Gatekeeper is an advanced anti-spam tool for MediaWiki <br/>
**This is a work-in-progress and actively maintained.**

## Requirements

- MediaWiki 1.39 or higher
- PHP 7.4+

## Installation
Clone or download this repository into your MediaWiki `extensions/` directory: <br/>
```
cd /path/to/mediawiki/extensions
git clone https://github.com/codedbyjake/GateKeeper.git
```

In your `LocalSettings.php` add:
`wfLoadExtension('GateKeeper');`

Alternatively, you can simply paste the contents of `gatekeeper-defaults.php` into the bottom of your `LocalSettings.php` to get started quickly with the default configuration.

Optionally, configure GateKeeper using the variables listed below in your `LocalSettings.php`

## Configuration

Admin Panel: You can access the GateKeeper configuration panel at `Special:GateKeeper` on your MediaWiki installation.

`$wgGatekeeperKeywords` 
  <br/>Type: `array` of strings
  <br/>Default: `None` (See examples)
  <br/>A simple configuration variable that defines a list of blacklisted spam phrases. Gatekeeper uses this list to scan page edits and block those containing any matching keyword.
<br/><br/>
`$wgGatekeeperBlockLinksFromNewUsers` 
  <br/>Type: `bool` 
  <br/>Default: `true`
  <br/>Enables or disables Gatekeeper’s protection against link posting by new or anonymous users. When enabled, users must meet a minimum edit threshold before they are allowed to include external links on pages. <br/><br/>
`$wgGatekeeperMinEditsToPostLinks`
  <br/>Type: `int`
  <br/>Default: `5`
  <br/>Defines the minimum number of edits a registered user must have made before being allowed to include external links on pages.<br/><br/>
`$wgGatekeeperLinkScoring`
  <br/>Type: `array`
  <br/>Default: `None` (See examples)
  <br/>Enables Gatekeeper’s link scoring system. This checks for things like suspicious TLDs, shortener URLs, repeated links to the same domain, and multiple outbound links. Each rule adds a configurable number of points. If the total score exceeds your set threshold, the edit is blocked. <br/><br/>
`$wgGatekeeperWhitelistedDomains`
  <br/>Type: `array` of domain strings
  <br/>Default: `None` (See examples)
  <br/>GateKeeper's link scoring will not penalise repeated links or TLDs for domains on this list, allowing users to safely link to sources like Wikipedia or Archive.org without triggering the spam filter.

## Enable Logging
`$wgDebugLogGroups['Gatekeeper'] = __DIR__ . '/extensions/GateKeeper/gatekeeper.log';`

## Credits
[@codedbyjake](https://github.com/codedbyjake)
