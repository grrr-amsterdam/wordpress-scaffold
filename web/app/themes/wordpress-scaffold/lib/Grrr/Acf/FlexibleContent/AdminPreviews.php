<?php namespace Grrr\Acf\FlexibleContent;

/**
 * Adds contextual content to styled flexible content blocks in the CMS.
 * Adjust names according to field names used in the flexible content blocks
 * to load content.
 */

class AdminPreviews {

    const FLEX_NAME = 'flexible_content';

    public function register() {
        add_filter(
            'acf/fields/flexible_content/layout_title/name=' . self::FLEX_NAME,
            [$this, 'filterLayoutTitles'], 1, 4
        );
    }

    public function filterLayoutTitles($title, $field, $layout, $i) {
        $out = '<span class="block-name">' . $title . '</span>';

        // Title
        if ($text = get_sub_field('title')):
            $out .= "<div class=\"title\">{$text}</div>";
        endif;

        // Image
        if ($image = get_sub_field('image')):
            if (is_array($image)) {
                $out .= '<div class="thumbnails"><div class="thumbnail"><img src="' .
                    $image['sizes']['thumbnail'] . '" height="36px" /></div></div>';
            }
        endif;

        // Multiple images
        if ($images = get_sub_field('images')):
            $count = 0;
            $out .= '<div class="thumbnails">';
            foreach ($images as $image):
                if ($count > 7) continue;
                $thumbnail = isset($image['sizes']) ? $image['sizes']['thumbnail'] :
                    $image['image']['sizes']['thumbnail'];
                $out .= '<div class="thumbnail"><img src="' . $thumbnail . '" height="36px" /></div>';
                $count++;
            endforeach;
            $out .= '</div>';
        endif;

        // Text block (body)
        if (!$text && $body = get_sub_field('description') ?: get_sub_field('text')):
            $out .= '<div class="body">' . strip_tags(substr($body, 0, 100)) . ' […]</div>';
        endif;

        // Quote
        if (!$text && $body = get_sub_field('quote')):
            $out .= '<div class="body">' . strip_tags(substr($body, 0, 100)) . ' […]</div>';
        endif;

        // Video
        if (!$text && !$image && $placeholder = get_sub_field('placeholder')) {
            if (is_array($placeholder)) {
                $out .= '<div class="thumbnails"><div class="thumbnail"><img src="' .
                    $placeholder['sizes']['thumbnail'] . '" height="36px" /></div></div>';
            }
        }

        return $out;
    }
}
