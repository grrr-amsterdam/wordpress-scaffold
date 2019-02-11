<?php namespace Grrr\Acf;

class Setup {

    public function register() {
        (new SyncWarning)->register();
        (new Options\Theme)->register();
        (new FlexibleContent\AdminTitles)->register();
    }

}
