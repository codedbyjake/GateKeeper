<?php
namespace Gatekeeper;

use OutputPage;
use Skin;
use Status;
use User;

class Hooks {

    public static function onBeforePageDisplay(OutputPage &$out, Skin &$skin): void {
        $title = $out->getTitle();
        if ($title && $title->isMainPage()) {
            $out->addHTML(
                '<div style="background: #000; color: #fff; padding: 1em; width: 50%; text-align: center;">
                    <strong>Gatekeeper active</strong>
                </div>'
            );
        }
    }

    public static function onEditFilterMergedContent(
        $context,
        $content,
        Status &$status,
        string $summary,
        User $user,
        bool $minoredit
    ): bool {
        $text = method_exists($content, 'getText') ? $content->getText() : '';
        $lowerText = strtolower($text);

        $title = $context->getTitle();
        $namespace = $title ? $title->getNamespace() : null;

        global $wgGatekeeperBlockLinksFromNewUsers, $wgGatekeeperMinEditsToPostLinks;

        if (
            ($wgGatekeeperBlockLinksFromNewUsers ?? true) &&
            preg_match('/https?:\/\//i', $text) &&
            ($user->isAnon() || $user->getEditCount() < ($wgGatekeeperMinEditsToPostLinks ?? 5))
        ) {
            $status->fatal('gatekeeper-blocklink');
            wfDebugLog('Gatekeeper', "Blocked external link edit from {$user->getName()} on page {$title->getPrefixedText()}");
            return false;
        }

        global $wgGatekeeperKeywords;
        $spamKeywords = $wgGatekeeperKeywords ?? [];

        foreach ($spamKeywords as $keyword) {
            if (strpos($lowerText, $keyword) !== false) {
                $status->fatal(wfMessage('gatekeeper-spamkeyword'));
                wfDebugLog('Gatekeeper', "Blocked edit from {$user->getName()} due to keyword: $keyword");
                return false;
            }
        }

        // Link scoring
        global $wgGatekeeperLinkScoring;
        if (
		isset($wgGatekeeperLinkScoring['enabled']) &&
		$wgGatekeeperLinkScoring['enabled'] === true &&
		preg_match_all('/https?:\/\/[^\s"]+/i', $text, $matches)
		) {
		$score = 0;
		$links = $matches[0];
		$domains = [];

            foreach ($links as $link) {
                $parsed = parse_url($link);
                $host = $parsed['host'] ?? '';

                // Suspicious TLDs
                if (preg_match('/\.(ru|xyz|top|click|pw|info|work|loan|gq|cf|ml|tk|ga|men|win|date|cam|party|stream|review|vip|icu|buzz|fit|rest|mom|link|shop|bar|kim|country|webcam|zip|ry|hosting|help|science|ninja|trade|bid|accountant|faith|surf|lol|live|space|press|pro|rocks|today|center|club|website)$/i', $host)) {
                    $score += $wgGatekeeperLinkScoring['rules']['suspiciousTLD'] ?? 0;
                }

                // Shorteners
                if (preg_match('/(bit\.ly|tinyurl\.com|goo\.gl|t\.co)/i', $host)) {
                    $score += $wgGatekeeperLinkScoring['rules']['shortener'] ?? 0;
                }

                // UTM or referral tokens
                if (strpos($link, 'utm_') !== false || strpos($link, '?ref=') !== false) {
                    $score += $wgGatekeeperLinkScoring['rules']['utmParams'] ?? 0;
                }

                // Count repeated domains
                $domains[$host] = ($domains[$host] ?? 0) + 1;
            }

            // Multiple external links
            if (count($links) > 2) {
                $score += $wgGatekeeperLinkScoring['rules']['multipleLinks'] ?? 0;
            }

            // Repeating same domain
            foreach ($domains as $domain => $count) {
                if ($count > 1) {
                    $score += $wgGatekeeperLinkScoring['rules']['repeatedDomain'] ?? 0;
                }
            }

            if ($score >= ($wgGatekeeperLinkScoring['threshold'] ?? 20)) {
                $status->fatal(wfMessage('gatekeeper-linkscore'));
                wfDebugLog('Gatekeeper', "Blocked edit from {$user->getName()} - spam score {$score} on page {$title->getPrefixedText()}");
                return false;
            }
        }

        return true;
    }
}
