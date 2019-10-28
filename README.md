# WordPress Scaffold

A highly opinionated WordPress Pro scaffold, built with ❤️ by [GRRR](https://grrr.tech). It includes:

- Dependency management via [Composer](https://getcomposer.org/)
- [Twig](https://twig.symfony.com/) templates via [Timber](https://github.com/timber/timber/)
- Front-end tooling using [@grrr/gulpfile](https://github.com/grrr-amsterdam/gulpfile/)
- Application deployments via [Capistrano](https://github.com/capistrano/capistrano)
- Static site generation and deployments via [Simply Static Deploy](https://github.com/grrr-amsterdam/simply-static-deploy)
- Advanced [ACF](https://www.advancedcustomfields.com/) integrations

## Requirements

- PHP 7.1+ with Composer
- Node 8+ with Yarn (front-end tooling)
- Ruby 2.2+ with Bundler (deploying)

View the [prerequisites](https://github.com/grrr-amsterdam/wordpress-scaffold/wiki/Prerequisites) in the wiki for more details.

When you're running the included [Docker setup](https://github.com/grrr-amsterdam/wordpress-scaffold/wiki/Docker) you only need PHP with Composer.

## Quick start

To create a new project, run:

```sh
$ composer create-project grrr-amsterdam/wordpress-scaffold <project-name>
```

After the project is created by Composer, you can run the `setup` command:

```sh
$ composer setup
```

This will trigger an interactive shell, which will prompt you with questions. The given answers will help configure the newly created project. See the [complete list of tasks](https://github.com/grrr-amsterdam/wordpress-scaffold/wiki/Setting-up-a-project) that will run during this interactive setup.

## Documentation

[View the wiki](https://github.com/grrr-amsterdam/wordpress-scaffold/wiki) for more instructions, usage examples and conventions.

---

This scaffold is inspired by:

- [roots/bedrock](https://github.com/roots/bedrock/)
- [roots/bedrock-capistrano](https://github.com/roots/bedrock-capistrano/)
- [roots/sage](https://github.com/roots/sage/)

The scaffold and theme rely heavily on:

- [timber/timber](https://github.com/timber/timber/)
- [@grrr/gulpfile](https://github.com/grrr-amsterdam/gulpfile/)
- [@grrr/hansel](https://github.com/grrr-amsterdam/hansel/)
- [@grrr/utils](https://github.com/grrr-amsterdam/grrr-utils/)
