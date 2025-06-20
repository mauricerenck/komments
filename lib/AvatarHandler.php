<?php

namespace mauricerenck\Komments;

class AvatarHandler
{

    public function __construct(private ?string $avatarReturnType = null, private ?string $avatarService = null)
    {
        $this->avatarReturnType = $avatarReturnType ?? option('mauricerenck.komments.avatar.returnType', 'img');
        $this->avatarService = $avatarService ?? option('mauricerenck.komments.avatar.service', 'gravatar');
    }

    public function getAvatar(string $authorGravatar, string $authorName): ?string
    {
        $avatarString = $this->getAvatarByType($authorGravatar, $authorName);

        if ($this->avatarService !== 'gravatar' && $this->avatarReturnType === 'svg') {
            return $avatarString;
        }

        if ($this->avatarReturnType === 'url') {
            return $avatarString;
        }

        return <<<HTMLTAG
            <img class="u-photo" src="$avatarString" alt="$authorName" />
        HTMLTAG;
    }

    public function getAvatarByType(string $authorGravatar, string $authorName): ?string
    {
        if ($this->avatarService === 'gravatar') {
            return $authorGravatar;
        }

        if ($this->avatarReturnType) {
            return $this->author_initials_svg_data_uri($authorName)['svg'];
        }

        return $this->author_initials_svg_data_uri($authorName)['dataUri'];
    }

    public function author_initials_svg_data_uri($author)
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

        // SVG string
        $svg = <<<SVG
    <svg width="100" height="100" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="komment-avatar-initials">
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
      <rect class="author-initials-bg" width="100" height="100"/>
      <text
        x="50"
        y="55"
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
