#!/bin/bash
cd web/app/themes

curl -Lo default.zip 'https://github.com/digitalunited/roots/archive/master.zip'
unzip default.zip

rm default.zip
mv roots-master default
