#!/bin/bash

if [ -z $1 ]; then
    tag="latest"
else
    tag=$1
fi

docker login gitlab.bastrucks.com:5050
docker build --platform linux/amd64 -t gitlab.bastrucks.com:5050/basworld/pim/api/ci:$tag --target ci docker/application --file docker/application/Dockerfile
docker push gitlab.bastrucks.com:5050/basworld/pim/api/ci:$tag
