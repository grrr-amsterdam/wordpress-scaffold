<?php namespace Grrr\PostTypes;

class Comment extends PostTypeStub {

    protected $type = 'comment';

    public function register() {
        add_action('admin_menu', [$this, 'adjust']);
    }

    public function adjust() {
        remove_menu_page('edit-comments.php');
    }

}
