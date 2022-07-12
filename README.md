# WordPress Scaffold

A highly opinionated WordPress Pro scaffold. It includes:

-   Dependency management via [Composer](https://getcomposer.org/)
-   [Twig](https://twig.symfony.com/) templates via [Timber](https://github.com/timber/timber/)
-   Front-end tooling using [@grrr/gulpfile](https://github.com/grrr-amsterdam/gulpfile/)
-   Application deployments via [Capistrano](https://github.com/capistrano/capistrano)
-   Static site generation and deployments via [Simply Static Deploy](https://github.com/grrr-amsterdam/simply-static-deploy)
-   Advanced [ACF](https://www.advancedcustomfields.com/) integrations

## Developed with ❤️ by [GRRR](https://grrr.nl)

-   GRRR is a [B Corp](https://grrr.nl/en/b-corp/)
-   GRRR has a [tech blog](https://grrr.tech/)
-   GRRR is [hiring](https://grrr.nl/en/jobs/)
-   [@GRRRTech](https://twitter.com/grrrtech) tweets

## Requirements

-   PHP 7.1+ with Composer
-   Node 8+ with Yarn (front-end tooling)
-   Ruby 2.2+ with Bundler (deploying)

View the [prerequisites](https://github.com/grrr-amsterdam/wordpress-scaffold/wiki/Prerequisites) in the wiki for more details.

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

# Using WordPress headless including Advanced Custom Fields (ACF)

<!-- @TODO This should be added to the Wiki (Github) -->

## Why not using GraphQL

[Explain that we organically moved to some standards from a different approach.]

## Using the WordPress REST API

With the [WordPress REST API Handbook](https://developer.wordpress.org/rest-api/) and the [WordPress REST API Reference](https://developer.wordpress.org/rest-api/reference/) as your guidance, here is a nice summary.

### Pages

Retrieve a collection of pages [(reference)](https://developer.wordpress.org/rest-api/reference/pages/#list-pages)

```
/wp-json/wp/v2/pages
```

Retrieve a single page [(reference)](https://developer.wordpress.org/rest-api/reference/pages/#retrieve-a-page)

```
/wp-json/wp/v2/pages/<id>
```

### Posts

Retrieve a collection of posts [(reference)](https://developer.wordpress.org/rest-api/reference/posts/#list-posts)

```
/wp-json/wp/v2/posts
```

Retrieve a single page [(reference)](https://developer.wordpress.org/rest-api/reference/posts/#retrieve-a-post)

```
/wp-json/wp/v2/posts/<id>
```

### Endpoint for custom post types

When registering the custom post type you should specify that it should be able to appear in the WordPress REST API.
You can do this by setting the `show_in_rest` argument on `true`.

**important** Don't forget to also set the `rest_base` argument to the plural form when you want to adhere to the JSON API standard.

example

```
'post_type' => 'example',
'show_in_rest' => true,
'rest_base' => 'examples',
```

### Advanced Custom Fields

You must enable a field group to have it been exposed by the api. You can find this setting within a field group's settings.

[[https://github.com/USERNAME/REPOSITORY/blob/upgrade/img/enable-acf-in-rest-api.png|alt="Enable ACF in rest api"]]

### Menus

### Multilingual using Polylang

## Next steps

---

This scaffold is inspired by:

-   [roots/bedrock](https://github.com/roots/bedrock/)
-   [roots/bedrock-capistrano](https://github.com/roots/bedrock-capistrano/)
-   [roots/sage](https://github.com/roots/sage/)

The scaffold and theme rely heavily on:

-   [timber/timber](https://github.com/timber/timber/)
-   [@grrr/gulpfile](https://github.com/grrr-amsterdam/gulpfile/)
-   [@grrr/hansel](https://github.com/grrr-amsterdam/hansel/)
-   [@grrr/utils](https://github.com/grrr-amsterdam/grrr-utils/)

```

```
