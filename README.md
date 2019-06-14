# Wordpress Scaffold

An opinionated WordPress 'Pro' scaffold. Includes a starter theme using [Twig](https://twig.symfony.com/) templates via [Timber](https://github.com/timber/timber/), and front-end tooling using [@grrr/gulpfile](https://github.com/grrr-amsterdam/gulpfile/). Built with ❤️ by [GRRR](https://grrr.tech).

## Requirements

- PHP 7.1+ with Composer
- Node 8+ with Yarn (front-end tooling)
- Ruby 2.2+ with Bundler (deploying)

## Quick start

To start a new project, run:

```
composer create-project grrr-amsterdam/wordpress-scaffold <project>
```

This will create a new project in the chosen directory. It will also initiate an interactive shell where the following things will be done for you:

- Install Composer dependencies (root and theme)
- Create and prefill a `.env` file (essentials only)
- Create a database
- Install WordPress
- Rename the theme folder
- Prefill the `style.css` file
- Install npm packages
- Run `yarn build`
- Activate the theme
- Activate default plugins
- Set some WordPress settings (like disabling comments)

## WordPress & plugins

[Composer](https://getcomposer.org/) is used to require WordPress and its plugins. Dependencies explicitly required by the theme can be included via a nested Composer file in the theme. This makes the theme more portable, however, this is not required.

#### Add a plugin

Requiring a plugin works by using [WordPress Packagist](https://wpackagist.org/). You can search for the plugin there, or use the slug found on the WordPress site: `https://wordpress.org/plugins/<plugin-slug>/`. 
    
To require a plugin, run:

```
composer require wpackagist-plugin/<plugin-slug>
```

#### Paid plugins

Paid plugins should be included in the repo, and excluded from exclusion in the `.gitignore`.

#### Update WordPress & plugins

Updating WordPress or plugins is as simple as running:

```
composer update johnpbloch/wordpress
```

Paid plugins can be updated in development, whereafter the updated files can be committed to the repo.

## Theme assets

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

[Capistrano](https://github.com/capistrano/capistrano) is used for deploying.
Run `bundle install` to install the necessary requirements, or run `gem install bundler` first if you don't have [Bundler](https://github.com/bundler/bundler).

Initial server setup can be done via `cap <env> deploy:setup`, after verifiying that the server config is correct in `config/deploy/<env>.rb` This will create a few directories, install Composer and WP-CLI, and copy some files which need to be persistent between deploys (eg. files in de `shared` folder).

Deployments should be done by calling the wrapper script:

```
sh deploy.sh <environment>
```

To quickly connect to a server, run the following WP-CLI command:

```
wp ssh <environment> [--server=<number>]
```

## Under the hood

This scaffold is inspired by:

- [roots/bedrock](https://github.com/roots/bedrock/)
- [roots/bedrock-capistrano](https://github.com/roots/bedrock-capistrano/)
- [roots/sage](https://github.com/roots/sage/)

It relies heavily on:

- [timber/timber](https://github.com/timber/timber/)
- [@grrr/gulpfile](https://github.com/grrr-amsterdam/gulpfile/)
