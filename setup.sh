#!/bin/bash

echo 'composer up'

docker-compose build
docker-compose up -d

echo 'register document to kong'

curl -i -X POST \
  --url http://localhost:8001/apis/ \
  --data 'name=document' \
  --data 'upstream_url=http://172.17.0.6' \
  --data 'request_host=document' \
  --data 'strip_request_path=true' \
  --data 'request_path=/document'