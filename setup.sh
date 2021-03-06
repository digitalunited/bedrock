#!/bin/bash
echo "Ange URL:en för development miljön (exempel: hausrock.se.test)"
read envURL
sed -i '' "s/hausrock.se.test/$envURL/g" .env.example
dbname=$(sed -e 's/\.\.*/_/' -e 's/.test//' <<< $envURL)
sed -i '' "s/database_name/$dbname/g" .env.example
cp .env.example .env

echo ""
echo "Skapar en ny databas..."
mysql -uroot -e "CREATE DATABASE ${dbname} /*\!40100 DEFAULT CHARACTER SET utf8 */;"
echo "Databas skapad! Namn: ${dbname}"
echo ""
echo "Nu öppnas development miljön var god att installera WordPress"
open http://$envURL
read -p "Klicka på [Enter] när WordPress är installerat (du behöver inte logga in)"

echo "Running composer update"
composer update

echo "Configuration WP"
wp theme activate careofhaus
wp plugin activate soil advanced-custom-fields-pro advanced-custom-fields-nav-menu-field cms-tree-page-view disable-comments filenames-to-latin post-duplicator vc-clean-up wordpress-clean-up js_composer gravityforms wp-stage-switcher
wp rewrite structure '/%postname%/' --hard
wp post create --post_type=page --post_title='Startsida' --post_status=publish
wp post delete 2 --force
wp post delete 1 --force
wp comment delete 1 --force
wp option update page_on_front 4
wp option update show_on_front page
wp option update blogdescription ''
wp cache flush

rm -rf web/app/themes/twentysixteen

echo "Dags att skapa repo"
echo ""
echo "Ange namn för repository på Bitbucket"
read bitbucketRepo

echo "Ange ditt användarnamn för Bitbucket"
read bitbucketUser

curl --user $bitbucketUser https://api.bitbucket.org/1.0/repositories/ \
--data name=$bitbucketRepo --data owner=careofhaus --data is_private=true

echo "Skapar repo"
echo ""

rm -rf .git
git init
git remote add origin git@bitbucket.org:careofhaus/$bitbucketRepo.git
git add .
git commit -m "Initial commit"
git push -u origin master
