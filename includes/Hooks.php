<?php
namespace Gatekeeper;

use OutputPage;
use Skin;
use Status;
use User;

class Hooks {

    // Testing hook
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
        $isUserNamespace = in_array($namespace, [NS_USER, NS_USER_TALK]);

        global $wgGatekeeperBlockLinksFromNewUsers, $wgGatekeeperMinEditsToPostLinks;
        if (
            ($wgGatekeeperBlockLinksFromNewUsers ?? true) &&
            !$isUserNamespace &&
            preg_match('/https?:\/\//i', $text) &&
            ($user->isAnon() || $user->getEditCount() < ($wgGatekeeperMinEditsToPostLinks ?? 5))
        ) {
            $status->fatal('gatekeeper-blocklink');
            wfDebugLog('Gatekeeper', "Blocked link edit from {$user->getName()} on page {$title->getPrefixedText()}");
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

        return true;
    }
}
