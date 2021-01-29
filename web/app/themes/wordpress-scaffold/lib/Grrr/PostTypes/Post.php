<?php namespace Grrr\PostTypes;

class Post extends PostTypeStub {

    protected $type = 'post';

    public function register() {
        add_action('init', [$this, 'adjust'], 1);
    }

    public function adjust() {
        remove_post_type_support($this->type, 'comments');
        remove_post_type_support($this->type, 'trackbacks');
    }

}
