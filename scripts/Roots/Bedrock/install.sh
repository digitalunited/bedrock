#!/bin/bash
cd web/app/themes
git clone git@bitbucket.org:careofhaus/care-of-haus-wordpress-theme.git careofhaus
cd careofhaus
npm install && bower install && gulp
rm -rf .git
echo "Kör nu setup.sh i root mappen"