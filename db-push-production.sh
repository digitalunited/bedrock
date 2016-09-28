#!/bin/bash
# Lägg till rätt plugins för varje enskilt projekt
wp plugin activate nginx-helper redirection wordpress-seo google-analytics-for-wordpress
bundle exec cap production wpcli:db:push
wp plugin deactivate nginx-helper redirection wordpress-seo google-analytics-for-wordpress