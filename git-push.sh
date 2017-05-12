#!/bin/sh

COMMIT_DATETIME=`date +'%Y-%m-%d %H:%M:%S %Z'`

git add . && git commit -m "Automated commit on ${COMMIT_DATETIME}" && git push -u origin master
