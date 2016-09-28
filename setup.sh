#!/bin/bash
echo "Ange URL:en för development miljön (exempel: hausrock.se.dev)"
read envURL
sed -i '' "s/hausrock.se.dev/$envURL/g" .env.example
echo "Ange databasnamn för development miljön (exempel: hausrock_se)"
read dbname
sed -i '' "s/database_name/$dbname/g" .env.example
cp .env.example .env

echo "Creating new WordPress database..."
mysql -uroot -e "CREATE DATABASE ${dbname} /*\!40100 DEFAULT CHARACTER SET utf8 */;"
echo "Database successfully created!"
echo ""
echo "Nu öppnas development miljön var god att installera WordPress"
open http://$envURL
read -p "Klicka på [Enter] när WordPress är installerat (du behöver inte logga in)"

wp theme activate careofhaus
wp plugin activate soil advanced-custom-fields-pro cms-tree-page-view disable-comments filenames-to-latin gravityforms post-duplicator vc-clean-up wordpress-clean-up js_composer
wp rewrite structure '/%postname%/' --hard
wp post create --post_type=page --post_title='Startsida' --post_status=publish
wp post delete 2 --force
wp post delete 1 --force
wp comment delete 1 --force
wp option update page_on_front 3
wp option update show_on_front page
wp option update blogdescription ''
wp cache flush

echo "Dags att skapa repo"
echo ""
echo "Ange namn för repository på Bitbucket"
read bitbucketRepo

echo "Ange ditt användarnamn för Bitbucket"
read bitbucketUser

curl --user $bitbucketUser https://api.bitbucket.org/1.0/repositories/ \
--data name=$bitbucketRepo --data owner=careofhaus

echo "Skapar repo"
echo ""

rm -rf .git
git init
git remote add origin git@bitbucket.org:careofhaus/$bitbucketRepo.git
git add .
git commit -m "Initial commit"
git push -u origin master