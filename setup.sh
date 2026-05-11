#!/bin/bash

#opennebula debian13-lamp template

set -e

PROJECT_DIR="/var/www/html/saitas"
REPO_URL="https://github.com/KotletasGT/plant-market.git"

DB_NAME="duomenys"
DB_USER="bosas"
DB_PASS="pass"

apt update && apt upgrade -y

apt install -y apache2 mariadb-server git curl unzip \
php php-cli php-mysql php-mbstring php-xml php-bcmath php-curl php-zip php-gd php-intl \
libapache2-mod-php nodejs npm

echo "Enabling Apache mod_rewrite..."
a2enmod rewrite
systemctl restart apache2

echo "Installing Composer..."
if ! command -v composer &> /dev/null
then
    curl -sS https://getcomposer.org/installer | php
    mv composer.phar /usr/local/bin/composer
fi

echo "Creating project directory..."
mkdir -p $PROJECT_DIR
chown -R www-data:www-data $PROJECT_DIR

rm -rf $PROJECT_DIR/*
git clone $REPO_URL $PROJECT_DIR

cd $PROJECT_DIR

composer install --no-dev --optimize-autoloader

npm install
npm run build

cp .env.example .env

sed -i "s/^#\s*DB_DATABASE=.*/DB_DATABASE=$DB_NAME/" .env
sed -i "s/^#\s*DB_USERNAME=.*/DB_USERNAME=$DB_USER/" .env
sed -i "s/^#\s*DB_PASSWORD=.*/DB_PASSWORD=$DB_PASS/" .env
sed -i "s/DB_CONNECTION=.*/DB_CONNECTION=mysql/" .env

php artisan key:generate
chown -R www-data:www-data $PROJECT_DIR
chmod -R 775 storage bootstrap/cache

echo "Setting up MySQL database..."
mysql -u root <<MYSQL_SCRIPT
CREATE DATABASE IF NOT EXISTS $DB_NAME;
CREATE USER IF NOT EXISTS '$DB_USER'@'localhost' IDENTIFIED BY '$DB_PASS';
GRANT ALL PRIVILEGES ON $DB_NAME.* TO '$DB_USER'@'localhost';
FLUSH PRIVILEGES;
MYSQL_SCRIPT

echo "Running migrations..."
php artisan migrate --force

echo "Configuring Apache VirtualHost..."

cat <<EOF > /etc/apache2/sites-available/saitas.conf
<VirtualHost *:80>
    ServerName localhost
    DocumentRoot $PROJECT_DIR/public

    <Directory $PROJECT_DIR/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog \${APACHE_LOG_DIR}/saitas_error.log
    CustomLog \${APACHE_LOG_DIR}/saitas_access.log combined
</VirtualHost>
EOF

a2dissite 000-default.conf
a2ensite saitas.conf
systemctl reload apache2

php artisan config:cache
php artisan route:cache
php artisan view:cache

sudo chmod 777 /var/www/html/saitas -R

php artisan storage:link

echo "OK"

#INSERT INTO admins (id, name, email, password)
#SELECT id, name, email, password
#FROM users
#WHERE id = 1;
