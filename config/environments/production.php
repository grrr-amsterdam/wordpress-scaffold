<?php
/** Production */
ini_set('display_errors', 0);
define('WP_DEBUG_DISPLAY', false);
define('SCRIPT_DEBUG', false);
define('WP_DISABLE_FATAL_ERROR_HANDLER', true);
/** Disable all file modifications including updates and update notifications */
define('DISALLOW_FILE_MODS', true);
