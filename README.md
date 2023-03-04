# Enterprise-Project

Setup project:

Step 1: Clone project from backend branch.

Step 2: Download xampp and install composer.

Step 3: At the end of Apache/Config/httpd.conf, append this configuration:


    <VirtualHost *:80>

    ServerName EPbackend.web

    DocumentRoot "<path_to_backend/web_folder>"
           
    <Directory "<path_to_backend/web_folder>">
      # use mod_rewrite for pretty URL support
       RewriteEngine on
      # If a directory or a file exists, use the request directly
       RewriteCond %{REQUEST_FILENAME} !-f
       RewriteCond %{REQUEST_FILENAME} !-d
      # Otherwise forward the request to index.php
       RewriteRule . index.php

      # use index.php as index file
       DirectoryIndex index.php

      # ...other settings...
      # Apache 2.4
       Require all granted
               
      ## Apache 2.2
      # Order allow,deny
      # Allow from all
    </Directory>


    </VirtualHost>

    <VirtualHost *:80>

    ServerName EPfrontend.web

    DocumentRoot "<path_to_frontend/web_folder>"
           
    <Directory "<path_to_frontend/web_folder>">
      # use mod_rewrite for pretty URL support
       RewriteEngine on
      # If a directory or a file exists, use the request directly
       RewriteCond %{REQUEST_FILENAME} !-f
       RewriteCond %{REQUEST_FILENAME} !-d
      # Otherwise forward the request to index.php
       RewriteRule . index.php

      # use index.php as index file
       DirectoryIndex index.php

      # ...other settings...
      # Apache 2.4
       Require all granted
               
      ## Apache 2.2
      # Order allow,deny
      # Allow from all
    </Directory>

    </VirtualHost>

Remember to change the path in configuration to project folders.

Step 4: Add this line to host file in c:\Windows\System32\Drivers\etc\hosts:

127.0.0.1   EPfrontend.web

127.0.0.1   EPbackend.web

Step 5: In phpmyadmin, create database named enterprise_project.

Step 6: Run composer update command (If the terminal warning "... zip and upzip ...", open Apache config in xampp control panel, choose php.ini and find for extension=zip, remove ";" character at the begining and run again) and php init to setup the project.

Step 7: Open project root in terminal, run: php yii migrate.

Step 8: Open http://EPbackend.web (for backend) and http://EPfrontend.web (for frontend).

Step 9: Create a department and a account with username "admin" (backdoor).

Step 10: Login and using features.
