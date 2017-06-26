# Wordpress Scaffold

A WordPress 'Pro' scaffold, based on the [Bedrock](https://github.com/roots/bedrock/) WordPress boilerplate, with a customized theme loosely based on [Sage](https://github.com/roots/sage/).

### Based on

- [roots/bedrock](https://github.com/roots/bedrock/) 1.7.x
- [roots/bedrock-capistrano](https://github.com/roots/bedrock-capistrano)
- [roots/sage](https://github.com/roots/sage/) 8.5.x

### Create a new project

Run `composer create-project grrr-amsterdam/wordpress-scaffold <project>`.
This will create a new project in the chosen directory. It will also initiate an interactive shell where the following things will be done for you:

- Install Composer dependencies
- Install npm packages
- Rename the theme folder
- Prefill the `style.css` file
- Create a `.env` file
- Create a database
- Install WordPress

### Plugins & other dependencies

WordPress and WordPress plugins should be required by Composer in the root of the project. Dependencies explicitly required by the theme (a SDK for accessing an API for example) should be included in the theme, which has its own `composer.json`.

Paid plugins should be included in the repo, and excluded form exclusion in the `.gitignore` file.

### Updating WordPress & plugins

Updating WordPress or plugins is as simple as running `composer update johnpbloch/wordpress` or `composer update` for everything.
Paid plugins can be updated in development, whereafter the updated files can be committed to the repo.

### Theme & asset building

We use `gulp` for managing our front-end assets.
Commands should be run from inside the theme folder: `web/app/themes/*`.

- For watching, run `gulp watch`
- For building production assets, run `gulp --production`
