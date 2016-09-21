#!/bin/bash
cd web/app/themes
git clone git@bitbucket.org:careofhaus/care-of-haus-wordpress-theme.git careofhaus
cd careofhaus
npm install && bower install && gulp
rm -rf .git
cd ../../../..
echo "Ange URL:en för development miljön (example: hausrock.se.dev)"
read envURL
sed -i '' "s/hausrock.se.dev/$envURL/g" .env.example
echo "Ange databasnamn för development miljön (example: hausrock_se)"
read dbname
sed -i '' "s/database_name/$dbname/g" .env.example
cp .env.example .env

echo "Creating new WordPress database..."
mysql -uroot -e "CREATE DATABASE ${dbname} /*\!40100 DEFAULT CHARACTER SET utf8 */;"
echo "Database successfully created!"
echo "Showing existing databases..."
mysql -uroot -e "show databases;"
echo ""
echo "Nu öppnas development miljön var god att installera WordPress"
open http://$envURL
echo ""
read -p "Klicka på [Enter] när WordPress är installerat"

wp theme install twentysixteen
wp theme activate careofhaus
wp plugin activate --all
