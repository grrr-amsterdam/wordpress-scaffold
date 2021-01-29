<?php namespace Grrr\PostTypes;

use Timber;

abstract class PostTypeStub {

    public function get_structured_data(Timber\Post $post, bool $asArray = false) {
        return $asArray ? [] : '';
    }

}
