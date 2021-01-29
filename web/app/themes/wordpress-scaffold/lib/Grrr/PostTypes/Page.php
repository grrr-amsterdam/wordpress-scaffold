<?php namespace Grrr\PostTypes;

class Page extends PostTypeStub {

    protected $type = 'page';

    public function register() {
        add_action('init', [$this, 'adjust'], 1);
    }

    public function adjust() {
        remove_post_type_support($this->type, 'author');
        remove_post_type_support($this->type, 'comments');
        remove_post_type_support($this->type, 'trackbacks');
        remove_post_type_support($this->type, 'thumbnail');
        remove_post_type_support($this->type, 'editor');
    }

}
