<?php namespace Grrr\Acf\FlexibleContent;

class AdminTitles {

    const FLEX_NAME = 'flexible_content';

    public function init() {
        add_filter(
            'acf/fields/flexible_content/layout_title/name=' . self::FLEX_NAME,
            [$this, 'filterLayoutTitles'], 1, 4
        );
    }

    public function filterLayoutTitles($title, $field, $layout, $i) {
        $out = '<span class="block-name">' . $title . '</span>';

        // title
        if ($text = get_sub_field('title')):
            $out .= "<div class=\"title\">{$text}</div>";
        endif;

        // image
        if ($image = get_sub_field('image')):
            if (is_array($image)) {
                $out .= '<div class="thumbnails"><div class="thumbnail"><img src="' .
                    $image['sizes']['thumbnail'] . '" height="36px" /></div></div>';
            }
        endif;

        // images
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

        // text block (body)
        if (!$text && $body = get_sub_field('description') ?: get_sub_field('text')):
            $out .= '<div class="body">' . strip_tags(substr($body, 0, 100)) . ' […]</div>';
        endif;

        // quote
        if (!$text && $body = get_sub_field('quote')):
            $out .= '<div class="body">' . strip_tags(substr($body, 0, 100)) . ' […]</div>';
        endif;

        // video block
        if (!$text && !$image && $placeholder = get_sub_field('placeholder')) {
            if (is_array($placeholder)) {
                $out .= '<div class="thumbnails"><div class="thumbnail"><img src="' .
                    $placeholder['sizes']['thumbnail'] . '" height="36px" /></div></div>';
            }
        }

        return $out;
    }
}
