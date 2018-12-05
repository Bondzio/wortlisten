#!/bin/bash

rsync -azv --cvs-exclude --exclude .idea --exclude '*.log' --exclude src/app.db --exclude htdocs/.htaccess --delete ./ private:/srv/www/woerter.r3wald.net/
