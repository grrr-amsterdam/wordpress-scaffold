<?php
namespace Grrr\Warp;

/**
 * PostCreateProject
 *
 * Some task that will be done after composer create-project
 *
 * @package Wordpress Scaffold
 * @author Ramiro Hammen <ramiro@grrr.nl>
 */
use Composer\Script\Event;
use Grrr\Warp\Util\StringUtil as S;

class PostCreateProject
{

    public static $event;
    public static $io;

    public static function setup(Event $event)
    {
        static::$event = $event;
        $io = $event->getIO();
        static::$io = $io;
        $io->write("\n<info>Setup project information. Press enter key for default.</info>");
        $questions = static::getEnvQuestions();
        $answers = static::askQuestions($questions);

        $io->write("\n<info>Updating .env file...</info>");
        $output = shell_exec("mv -n .env.template .env");
        $io->write("\n" . $output);
        $dotEnv = new Util\DotEnv(self::_getRootPath());
        $answers = static::parseAnswers($answers);
        $dotEnv->replaceVariables($answers);
        $io->write('.env file updated');

        $io->write("\n<info>Creating database...</info>");
        try {
            static::_createDatabase($dotEnv);
        } catch (\PDOException $e) {
            $errorMessage = $e->getMessage();
            $io->write("<error>{$errorMessage}</error>");
        }

        $io->write("\n<info>Setup Theme Settings</info>");
        $answers = static::askQuestions(static::getThemeQuestions());
        static::_updateThemeSettings($answers);
        $themeName = $answers['TEXT_DOMAIN'];

        $io->write("\n<info>Start installation of Wordpress</info>");
        $answers = static::askQuestions(static::getWordpressInstallQuestions());
        $result = static::_installWordpress($answers);
        $io->write($result);

        $io->write("\n<info>Installing Theme Dependencies</info>");
        $themePath = self::_getThemePath($themeName);
        $output = shell_exec("cd {$themePath} && composer install");
        $io->write("\n" . $output);
        $hasYarn = shell_exec("command -v yarn >/dev/null 2>&1 && echo 1 || echo 0");
        if (intval($hasYarn)) {
            $output = shell_exec("cd {$themePath} && yarn");
        } else {
            $output = shell_exec("cd {$themePath} && npm install");
        }
        $io->write("\n" . $output);
        $output = shell_exec("cd {$themePath} && gulp");
        $io->write("\n" . $output);
        shell_exec("cd " . self::_getRootPath());

        $io->write("\n<info>Activate theme & plugins</info>");
        $output = shell_exec("wp theme activate {$themeName}");
        $io->write("\n" . $output);
        $output = shell_exec("wp plugin activate soil");
        $io->write("\n" . $output);
    }

    protected static function askQuestions($questions) {
        $answers = [];
        foreach ($questions as $key => $config) {
            $answers[$key] = static::askQuestion($config);
        }
        return $answers;
    }

    protected static function parseAnswers($answers) {
        $answers['DB_PREFIX'] = $answers['DB_PREFIX'] . '_';
        return $answers;
    }

    protected static function askQuestion($config) {
        $question = $config['question'] . " ({$config['default']}): ";
        if (!empty($config['validator'])) {
            return static::$io->askAndValidate(
                $question, $config['validator'], null, $config['default']
            );
        }
        return static::$io->ask($question, $config['default']);
    }

    protected static function getWordpressInstallQuestions() {
        return [
            'site_title' => [
                'question' => 'Please give your site\'s title?',
                'default' => static::_composeThemeName(),
            ],
            'admin_user' => [
                'question' => 'What will be the admin\'s username?',
                'default' => 'Grrr'
            ],
            'admin_email' => [
                'question' => 'What will be the admin\'s email?',
                'default' => 'wordpress@grrr.nl'
            ],
            'admin_password' => [
                'question' => 'Please provide the admin\'s password',
                'default' => 'secret',
                'type' => 'password'
            ]
        ];
    }

    protected static function getEnvQuestions()
    {
        $questions = [
            'DB_HOST' => [
                'question' => 'Database host',
                'default' => '127.0.0.1'
            ],
            'DB_NAME' => [
                'question' => 'Database name',
                'default' => str_replace('-', '_', static::_composeProjectName() . '_d')
            ],
            'DB_USER' => [
                'question' => 'Database user',
                'default' => 'garp_development'
            ],
            'DB_PASSWORD' => [
                'question' => 'Database password',
                'default' => 'welovegarp'
            ],
            'DB_PREFIX' => [
                'question' => 'Database prefix',
                'default' => 'grrr',
                'validator' => function($value) {
                    if (empty($value)) {
                        throw new \Exception("Value is required");
                    }
                    return $value;
                }
            ],
            'WP_HOME' => [
                'question' => 'What will be your local site url? (incl. `http://`)',
                'default' => NULL,
                'validator' => function($value) {
                    if (empty($value)) {
                        throw new \Exception('You need to give an url');
                    }
                    return $value;
                }
            ]

        ];
        return $questions;
    }

    protected static function getThemeQuestions() {
        return [
            'THEME_NAME' => [
                'question' => 'Give your theme a name',
                'default' => static::_composeThemeName()
            ],
            'THEME_URI' => [
                'question' => 'What is your Theme URI',
                'default' => 'https://grrr.nl'
            ],
            'AUTHOR' => [
                'question' => 'What is the Author\'s name',
                'default' => 'Grrr'
            ],
            'AUTHOR_URI' => [
                'question' => 'What is the Author\'s URI',
                'default' => 'https://grrr.nl'
            ],
            'TEXT_DOMAIN' => [
                'question' => 'What is your theme\'s textdomain',
                'default' => static::_composeProjectName()
            ]
        ];
    }

    protected static function _createDatabase($dotEnv) {
        $db_host = $dotEnv->get('DB_HOST');
        $db_name = $dotEnv->get('DB_NAME');
        $db_user = $dotEnv->get('DB_USER');
        $db_password = $dotEnv->get('DB_PASSWORD');
        $conn = new \PDO("mysql:host={$db_host}", $db_user, $db_password);
        $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $sql = "CREATE DATABASE {$db_name}";
        $conn->exec($sql);
    }

    protected static function _updateThemeSettings($data) {
        $themeStylesheetPath = static::_getRootPath() . '/web/app/themes/wordpress-scaffold/style.css';
        $stylesheetContent = file_get_contents($themeStylesheetPath);
        file_put_contents($themeStylesheetPath, S::interpolate($stylesheetContent, $data));
        $themeFolderRenamed = static::_renameThemeDirectory($data['TEXT_DOMAIN']);
    }

    protected static function _installWordpress($data) {
        $dotEnv = new Util\DotEnv(self::_getRootPath());
        $url = $dotEnv->get('WP_HOME');
        $installCommand = "wp core install --url={$url} --title=\"{$data['site_title']}\" "
            . "--admin_user=\"{$data['admin_user']}\" "
            . "--admin_password=\"{$data['admin_password']}\" "
            . "--admin_email={$data['admin_email']}";

        return shell_exec($installCommand);
    }

    protected static function _composeProjectName()
    {
        $vendorDir = self::$event->getComposer()->getConfig()->get('vendor-dir');
        return pathinfo(dirname($vendorDir))['basename'];
    }

    protected static function _composeThemeName()
    {
        $projectName = self::_composeProjectName();
        $themeName = str_replace('_', ' ', self::_composeProjectName());
        $themeName = str_replace('-', ' ', $themeName);
        $themeName = ucfirst($themeName);
        return $themeName;
    }

    protected static function _getRootPath()
    {
        $vendorDir = self::$event->getComposer()->getConfig()->get('vendor-dir');
        return pathinfo($vendorDir)['dirname'];
    }

    protected static function _renameThemeDirectory($newName) {
        $themePath = self::_getThemePath('wordpress-scaffold');
        $newPath = self::_getRootPath() . '/web/app/themes/' . strtolower($newName);
        return rename($themePath, $newPath);
    }

    protected static function _getThemePath($themeName) {
        return self::_getRootPath() . '/web/app/themes/' . $themeName;
    }
}
