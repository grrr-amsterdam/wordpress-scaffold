<?php namespace Grrr\Acf;

class Setup {

    public function register() {
        if (!class_exists('acf')) {
            return;
        }

        (new SyncWarning)->register();
        (new Options\Theme)->register();
        (new FlexibleContent\AdminTitles)->register();
    }

}
