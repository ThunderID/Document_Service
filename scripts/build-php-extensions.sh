#!/bin/sh

apk add re2c alpine-sdk php5-dev autoconf imagemagick-dev libtool zlib-dev pcre-dev

pecl_install ()
{
  local EXT_TYPE=$1
  local NAME=$2
  local VERSION=$3
  local CONFIGURE_ARGS=$(shift 3; echo $@)
  local PECL_URL="https://pecl.php.net/get/$NAME-$VERSION.tgz"

  cd /tmp
  curl $PECL_URL -O
  tar xzf $NAME-$VERSION.tgz
  cd /tmp/$NAME-$VERSION
  phpize
  ./configure $CONFIGURE_ARGS
  make
  make install
  echo "$EXT_TYPE=$NAME.so" >> /etc/php5/conf.d/$NAME.ini
}

# Install PHP extensions
pecl_install extension apcu 4.0.10 --enable-apcu
pecl_install zend_extension xdebug 2.3.3 --enable-xdebug

pecl_install extension mongodb 1.1.8
pecl_install extension mongo 1.6.14
# Cleanup

rm -rf /tmp/*
