#!/bin/bash
cd web/app/themes
git clone git@bitbucket.org:careofhaus/care-of-haus-wordpress-theme.git careofhaus
cd careofhaus
npm install && bower install && gulp
rm -rf .git
cd ../../../..

# If /root/.my.cnf exists then it won't ask for root password
if [ -f /root/.my.cnf ]; then
	echo "Please enter the NAME of the new WordPress database! (example: database1)"
	read dbname
	echo "Please enter the WordPress database CHARACTER SET! (example: latin1, utf8, ...)"
	read charset
	echo "Creating new WordPress database..."
	mysql -e "CREATE DATABASE ${dbname} /*\!40100 DEFAULT CHARACTER SET ${charset} */;"
	echo "Database successfully created!"
	echo "Showing existing databases..."
	mysql -e "show databases;"
	echo ""
	echo "You're good now :)"
	exit

# If /root/.my.cnf doesn't exist then it'll ask for root password
else
	echo "Please enter root user MySQL password!"
	read rootpasswd
	echo "Please enter the NAME of the new WordPress database! (example: database1)"
	read dbname
	echo "Please enter the WordPress database CHARACTER SET! (example: latin1, utf8, ...)"
	read charset
	echo "Creating new WordPress database..."
	mysql -uroot -p${rootpasswd} -e "CREATE DATABASE ${dbname} /*\!40100 DEFAULT CHARACTER SET ${charset} */;"
	echo "Database successfully created!"
	echo "Showing existing databases..."
	mysql -uroot -p${rootpasswd} -e "show databases;"
	echo ""
	echo "You're good now :)"
	exit
fi

wp theme install twentysixteen
wp theme activate careofhaus