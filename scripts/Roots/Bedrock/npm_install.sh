#!/bin/bash
cd web/app/themes
git clone git@bitbucket.org:careofhaus/care-of-haus-premium-starter-child-theme.git
cd careofhaus-child
npm install && bower install && gulp
