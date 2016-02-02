#!/bin/bash
cd web/app/themes
git clone git@bitbucket.org:careofhaus/care-of-haus-premium-starter-child-theme.git careofhaus-child
cd careofhaus-child
npm install && bower install && gulp
rm -rf .git