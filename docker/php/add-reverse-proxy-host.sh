#!/bin/sh
# @author       David Spreekmeester <david@grrr.nl>
# @description  Solaris shell script to add a mock localhost entry to a container,
#               enabling it to reach the proxy container by the same hostname
#               as you would use from your host as a developer.

# Provide this script with 2 arguments:
# 1. Name of the Docker service, f.i. 'web'
REV_PROXY_SERVICE=$1
# 2. Domain that you will address this service by, f.i. 'poobar.localhost'
REV_PROXY_DOMAIN=$2
[ -z "$1" ] && echo 'Missing arg 1:' && \
    echo 'Provide the Docker service that functions as proxy, f.i. "web"' && exit 1
[ -z "$2" ] && echo 'Missing arg 2:' && \
    echo 'Provide the hostname you use to address the proxy, f.i. "poobar.localhost"' && exit 1

# Wait for Docker to provision the containers with internally mapped `hosts` files.
sleep 5
NAMESERVER=$(cat /etc/resolv.conf | grep nameserver | awk '{print $2}')
NSLOOKUP="$(nslookup ${REV_PROXY_SERVICE} ${NAMESERVER})"
REV_PROXY_IP=$(printf "${NSLOOKUP}" | grep 'Address 1' | grep ${REV_PROXY_SERVICE} | awk '{print $3'})

[ -z "$REV_PROXY_IP" ] && echo "Unable to find '${REV_PROXY_SERVICE}'. Provide a valid container name." && exit 1

echo "${REV_PROXY_IP} ${REV_PROXY_DOMAIN}" >> /etc/hosts
