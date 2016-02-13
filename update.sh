#!/bin/bash

DIR=`dirname $0`

echo Current directory: ${DIR}

cd ${DIR}
git pull origin master
/usr/bin/composer update -d ${DIR}
/usr/bin/php ${DIR}/app/task.php migration run
rm -f ${DIR}/app/cache/metadata/*
