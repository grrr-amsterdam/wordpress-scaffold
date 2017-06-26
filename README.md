# Wordpress Scaffold

A WordPress 'Pro' scaffold, based on the [Bedrock](https://github.com/roots/bedrock/) WordPress boilerplate, with a customized theme loosely based on [Sage](https://github.com/roots/sage/).

### Based on

- [roots/bedrock](https://github.com/roots/bedrock/) 1.7.x
- [roots/bedrock-capistrano](https://github.com/roots/bedrock-capistrano)
- [roots/sage](https://github.com/roots/sage/) 8.5.x

## Quick start

### Create a new project

Run `composer create-project grrr-amsterdam/wordpress-scaffold <project>`.
This will create a new project in the chosen directory. It will also initiate an interactive shell where the following things will be done for you:

- Install Composer dependencies
- Install npm packages
- Rename the theme folder
- Prefill the `style.css` file
- Create and prefill a `.env` file
- Create a database
- Install WordPress

### Theme & asset building

We use [Yarn](https://github.com/yarnpkg/yarn) for managing our front-end dependencies, and (Gulp)[https://github.com/gulpjs/gulp] for building all the assets.
Commands should be run from inside the theme folder: `web/app/themes/*`.

- For watching, run `gulp watch`
- For building production assets, run `gulp --production`

### Deploying

We use [Capistrano](https://github.com/capistrano/capistrano) for deployments.
Run `bundle install` to install the necessary requirements, or run `gem install bundler` first if you don't have [Bundler](https://github.com/bundler/bundler).

Initial server setup can be done via `cap <env> deploy:setup`, after verifiying that the server config is correct in `config/deploy/<env>.rb` This will create a few directories, install Composer and WP-CLI, and copy some files which need to be persistent between deploys (eg. files in de `shared` folder).

Deployments and rollbacks can be done via:

`cap <env> deploy` and `cap <env> deploy:rollback`

## Structure & flow

### Theme settings & logic

We try to avoid extensive logic in templates or partials. Most logic can be found in `lib\<namespace>`, and all classes are autoloaded thru [PSR-4](http://www.php-fig.org/psr/psr-4/). Files with classless functions (like `Utils.php`) need to be specified explicitly in the `autoload` entry of the `composer.json`.

### Plugins & dependencies

WordPress and WordPress plugins should be required by Composer in the root of the project. Dependencies explicitly required by the theme (a SDK for accessing an API for example) should be included in the theme, which has its own `composer.json`.

Paid plugins should be included in the repo, and excluded form exclusion in the `.gitignore` file.

### Updating WordPress & plugins

Updating WordPress or plugins is as simple as running `composer update johnpbloch/wordpress` or `composer update` for everything.
Paid plugins can be updated in development, whereafter the updated files can be committed to the repo.
