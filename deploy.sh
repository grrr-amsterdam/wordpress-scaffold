#!/bin/sh

init() {
    if [ -z "$1" ]; then
        echo "Provide the environment as the first argument."
        echo "$ sh deploy.sh staging"
        exit
    fi
    if [ "$1" == "production" ] && [ -z "$2" ]; then
        echo "Provide a tag as the second argument."
        echo "$ sh deploy.sh production <tag>"
        exit
    fi

    install_composer_packages
    install_ruby_bundler
}

install_composer_packages() {
    if command -v composer 2>/dev/null; then
        composer install
    else
        echo 'No PHP Composer available.'
        exit 1;
    fi
}

install_ruby_bundler() {
    gem install bundler &&
    bundle install
}

deploy() {
    echo '🤖  [Deploying]'
    export PATH=$PATH:$(npm bin);

    if [ ! -z "$2" ]; then
        bundle exec cap $1 deploy tag=$2
    else
        bundle exec cap $1 deploy
    fi
}

init $1 $2 &&
deploy $1 $2
