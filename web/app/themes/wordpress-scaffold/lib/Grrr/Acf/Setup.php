<?php namespace Grrr\Acf;

class Setup {

    public function register() {
        (new SyncWarning)->register();
        (new SelectPrefiller)->register();
        (new WysiwygToolbars)->register();
        (new Options\Theme)->register();
        (new FlexibleContent\AdminPreviews)->register();
    }

}
