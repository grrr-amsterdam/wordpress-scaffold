<?php namespace Grrr\PostTypes;

use Spatie\SchemaOrg\Schema;
use Timber;

class Faq extends PostTypeAbstract {

    protected $type = 'faq';
    protected $slug = 'faq';
    protected $icon = 'dashicons-editor-help';

    protected $labels = [
        'name' => 'FAQs',
        'singular_name' => 'FAQ',
    ];

    protected $args = [
        'public' => true,
        'has_archive' => true,
        'show_in_rest' => true,
        'rest_base' => 'faqs',
        'supports' => [
            'title',
            'revisions',
        ],
    ];

    public function get_structured_data(Timber\Post $post, bool $asArray = false) {
        $answer = Schema::Answer()->text($post->meta('answer') ?: '');
        $question = Schema::Question()->name($post->title)->acceptedAnswer($answer);
        $data = Schema::FAQPage()->mainEntity($question);
        return $asArray
            ? $data->toArray()
            : $data->toScript();
    }

}
