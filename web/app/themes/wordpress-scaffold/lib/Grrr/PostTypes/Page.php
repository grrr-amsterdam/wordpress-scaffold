<?php namespace Grrr\PostTypes;

class Page {

    protected $_type = 'page';

    public function register() {
        add_action('init', [$this, 'adjust'], 1);
    }

    public function adjust() {
        remove_post_type_support($this->_type, 'author');
        remove_post_type_support($this->_type, 'comments');
        remove_post_type_support($this->_type, 'trackbacks');
        remove_post_type_support($this->_type, 'thumbnail');
        remove_post_type_support($this->_type, 'editor');
    }

}
