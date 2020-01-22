FROM node:12-alpine3.10

ENV RUBY_DEPS ruby ruby-bundler ruby-dev
ENV CAP_DEPS git openssh
ENV USER $USER

RUN apk add --no-cache \
    autoconf \
    zlib \
    build-base \
    nasm \
    $RUBY_DEPS \
    $CAP_DEPS \
    # Configure Ruby and Bundler
    && echo "gem: --no-document" > ~/.gemrc \
    && bundle config --global silence_root_warning 1
