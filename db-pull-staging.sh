#!/bin/bash
# Lägg till rätt plugins för varje enskilt projekt
bundle exec cap staging wpcli:db:pull
wp plugin deactivate nginx-helper redirection wordpress-seo google-analytics-for-wordpress