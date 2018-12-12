<?php

namespace Grrr\PostTypes;

class Post {

    protected $_type = 'post';

    public function init() {
        add_action('init', [$this, 'adjust'], 1);
    }

    public function adjust() {
        remove_post_type_support($this->_type, 'comments');
        remove_post_type_support($this->_type, 'trackbacks');
    }

}
