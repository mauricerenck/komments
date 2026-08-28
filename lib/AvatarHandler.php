<?php

namespace mauricerenck\Komments;

class AvatarHandler
{

    public function __construct(private ?string $avatarReturnType = null, private ?string $avatarService = null, private ?string $avatarDefault = null, private ?int $avatarSize = null, private ?bool $webmentionAvatars = null)
    {
        $this->avatarReturnType = $avatarReturnType ?? option('mauricerenck.komments.avatar.returnType', 'img');
        $this->avatarService = $avatarService ?? option('mauricerenck.komments.avatar.service', 'gravatar');
        $this->avatarDefault = $avatarDefault ?? option('mauricerenck.komments.avatar.gravatarDefault', 'identicon');
        $this->avatarSize = $avatarSize ?? option('mauricerenck.komments.avatar.size', 100);
        $this->webmentionAvatars = $webmentionAvatars ?? option('mauricerenck.komments.avatar.webmentionAvatars', true);
    }


    public function avatar(string | null $md5hash, ?string $altText = '')
    {
        // no email data, return initials svg
        if (!isset($md5hash) || empty($md5hash)) {
            return $this->returnInitialsAvatar($altText);
        }

        // gravatar disabled, return initials svg
        if ($this->avatarService === 'initials') {
            return $this->returnInitialsAvatar($altText);
        }

        // FEAT: local caching of avatars
        $cachedAvatar = null;

        // return gravatar, return type is always img
        if (!$cachedAvatar) {
            $avatarString = 'https://www.gravatar.com/avatar/' . $md5hash . '?d=' . $this->avatarDefault . '&s=' . $this->avatarSize;

            return <<<HTMLTAG
            <img class="u-photo" src="$avatarString" alt="$altText" />
            HTMLTAG;
        }

        // fallback return initials svg
        return $this->returnInitialsAvatar($altText);
    }

    public function returnInitialsAvatar(string $altText)
    {
        $svgAvatar = $this->author_initials_svg_data_uri($altText);

        // return type: url
        if ($this->avatarReturnType === 'url') {
            return $svgAvatar['dataUri'];
        }

        // return type: svg
        if ($this->avatarReturnType === 'svg') {
            return $svgAvatar['svg'];
        }

        // return type: img
        $dataUri = $svgAvatar['dataUri'];
        return <<<HTMLTAG
                <img class="u-photo" src="$dataUri" alt="$altText" />
                HTMLTAG;
    }


    public function author_initials_svg_data_uri(string $author): array
    {
        // Extract initials
        $words = preg_split('/\s+/', trim($author));
        if (count($words) === 1) {
            $initials = mb_substr($words[0], 0, 2);
        } else {
            $initials = '';
            foreach (array_slice($words, 0, 2) as $word) {
                $initials .= mb_substr($word, 0, 1);
            }
        }
        $initials = htmlspecialchars($initials);

        $textPositionX = $this->avatarSize / 2;
        $textPositionY = $this->avatarSize / 2 + 5;

        // SVG string
        $svg = <<<SVG
    <svg width="$this->avatarSize" height="$this->avatarSize" viewBox="0 0 $this->avatarSize $this->avatarSize" xmlns="http://www.w3.org/2000/svg" class="komment-avatar-initials">
    <style>
        .author-initials-bg { fill: var(--author-bg, #1391a4); }
        .author-initials-text {
          fill: var(--author-text, #fff);
          font-family: var(--author-font-family, system-ui, sans-serif);
          font-size: var(--author-font-size, 40px);
          font-weight: var(--author-font-weight, bold);
          dominant-baseline: middle;
          text-anchor: middle;
          text-transform: uppercase;
        }
      </style>
      <rect class="author-initials-bg" width="$this->avatarSize" height="$this->avatarSize"/>
      <text
        x="$textPositionX"
        y="$textPositionY"
        class="author-initials-text"
        dominant-baseline="middle"
        text-anchor="middle"
      >$initials</text>
    </svg>
    SVG;

        // Encode as data URI
        $svg = preg_replace('/\s+/', ' ', trim($svg)); // Minify
        $dataUri = 'data:image/svg+xml;utf8,' . rawurlencode($svg);

        return [
            'dataUri' => $dataUri,
            'svg' => $svg,
        ];
    }
}
