#!/bin/bash
cd web/app/themes

curl -Lo default.zip 'http://github.com/digitalunited/sage/archive/master.zip'
unzip default.zip

rm default.zip
mv sage-master default
cd default
