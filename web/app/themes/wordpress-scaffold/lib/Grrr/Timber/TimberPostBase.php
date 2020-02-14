<?php namespace Grrr\Timber;

use Garp\Functional as f;
use Grrr\PostTypes\PostTypeRegistry;
use Timber;
use WP_Post;

class TimberPostBase extends Timber\Post {

    protected $post;

    public function __construct(?WP_Post $post = null) {
        $this->post = $post;
        parent::__construct($post);
    }

    public function structured_data(...$args) {
        return PostTypeRegistry::create_class($this->post->post_type)
            ->get_structured_data(new static($this->post), ...$args);
    }

}
