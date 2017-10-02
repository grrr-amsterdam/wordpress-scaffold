#!/bin/sh

init() {
    if [ -z "$1" ]; then
        echo "Provide the environment as the first argument."
        echo "$ sh deploy.sh staging"
        exit
    fi

    install_ruby_bundler
}

install_ruby_bundler() {
    gem install --user-install bundler && bundle
}

deploy() {
    echo '🤖  [Deploying]'
    bundle exec cap $1 deploy
}

init $1 &&
deploy $1
