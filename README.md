# Wordpress Scaffold

A WordPress 'Pro' scaffold, including a starter theme using [Twig](https://twig.symfony.com/) templates via [Timber](https://github.com/timber/timber/).

## Quick start

To start a new project, run:

```
composer create-project grrr-amsterdam/wordpress-scaffold <project>
```

This will create a new project in the chosen directory. It will also initiate an interactive shell where the following things will be done for you:

- Install root Composer dependencies
- Create and prefill a `.env` file (essentials only)
- Create a database
- Install WordPress
- Rename the theme folder
- Prefill the `style.css` file
- Install theme Composer dependencies
- Install npm packages
- Run `yarn build`
- Activate the theme
- Active some default plugins
- Set a few default WordPress settings (like disabling comments)

## Theme & asset building

[Yarn](https://github.com/yarnpkg/yarn) is used for managing front-end dependencies, and [@grrr/gulpfile](https://github.com/grrr-amsterdam/gulpfile) for building front-end assets.

Commands should be run from inside the theme folder: `web/app/themes/*`

#### Development

```
yarn watch
```

#### Production
```
yarn build:production
```

## Deploying

[Capistrano](https://github.com/capistrano/capistrano) is used for deployments.
Run `bundle install` to install the necessary requirements, or run `gem install bundler` first if you don't have [Bundler](https://github.com/bundler/bundler).

Initial server setup can be done via `cap <env> deploy:setup`, after verifiying that the server config is correct in `config/deploy/<env>.rb` This will create a few directories, install Composer and WP-CLI, and copy some files which need to be persistent between deploys (eg. files in de `shared` folder).

Deployments can be done by running:

```
sh deploy.sh <environment>
```

## Structure & dependency flow

### Theme settings & logic

We try to avoid extensive logic in templates or partials. Most logic can be found in `lib\<namespace>`, and all classes are autoloaded thru [PSR-4](http://www.php-fig.org/psr/psr-4/). Directories with classless functions (like `libs/Grrr/Utils`) need to be specified explicitly in the `functions.php`. Loading them thru Composer will fail, since we 'hoist' the theme composer dependencies to the main `composer.json` on install.

### Plugins & dependencies

WordPress and its plugins should be required by Composer in the root of the project. Dependencies explicitly required by the theme (a SDK for accessing an API for example) should be included in the theme, which has its own `composer.json`.

Requiring a plugin works by using [WordPress Packagist](https://wpackagist.org/):

```
composer require wpackagist-plugin/<plugin-slug>
```

Paid plugins should be included in the repo, and excluded form exclusion in the `.gitignore` file.

### Updating WordPress & plugins

Updating WordPress or plugins is as simple as running:

```
composer update johnpbloch/wordpress
```

Paid plugins can be updated in development, whereafter the updated files can be committed to the repo.

## Under the hood

The scaffold is inspired by:

- [roots/bedrock](https://github.com/roots/bedrock/)
- [roots/bedrock-capistrano](https://github.com/roots/bedrock-capistrano/)
- [roots/sage](https://github.com/roots/sage/)

It relies heavily on:

- [timber/timber](https://github.com/timber/timber/)
- [grrr-amsterdam/gulpfile](https://github.com/grrr-amsterdam/gulpfile/)
