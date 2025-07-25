# GateKeeper
Gatekeeper is an advanced anti-spam tool for MediaWiki <br/>
**This is a work in-progress extension**

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

Optionally, configure GateKeeper using the variables listed below in your `LocalSettings.php.`

## Configuration

`$wgGatekeeperKeywords` 
  <br/>Type: `array` of strings
  <br/>A simple configuration variable that defines a list of blacklisted spam phrases. Gatekeeper uses this list to scan page edits and block those containing any matching keyword.
<br/><br/>
`$wgGatekeeperBlockLinksFromNewUsers` 
  <br/>Type: `bool` 
  <br/>Default: `true`
  <br/>Enables or disables Gatekeeper’s protection against link posting by new or anonymous users. When enabled, users must meet a minimum edit threshold before they are allowed to include links on pages. <br/><br/>
`$wgGatekeeperMinEditsToPostLinks`
  <br/>Type: `int`
  <br/>Default: `5`
  <br/>Defines the minimum number of edits a registered user must have made before being allowed to include external links on pages.

## Credits
[@codedbyjake](https://github.com/codedbyjake)
