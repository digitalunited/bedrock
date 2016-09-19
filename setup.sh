#!/bin/bash
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
echo ""
echo "Nu öppnas development miljön var god att installera WordPress"
open http://$envURL
read -p "Klicka på [Enter] när WordPress är installerat"

wp theme activate careofhaus
wp plugin activate soil advanced-custom-fields-pro cms-tree-page-view disable-comments filenames-to-latin gravityforms post-duplicator vc-clean-up wordpress-clean-up visual-composer
wp rewrite structure '/%postname%/'
wp post create --post_type=page --post_title='Startsida' --post_status=publish
wp post delete 2 --force
wp post delete 1 --force
wp comment delete 1 --force
wp option update page_on_front 3
wp option update show_on_front page
wp option update blogdescription ''