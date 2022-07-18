========= Before starting the application =========

Install XAMPP and locate the xampp folder
Link: https://downloadsapachefriends.global.ssl.fastly.net/8.1.6/xampp-windows-x64-8.1.6-0-VS16-installer.exe?from_af=true
this is the possible location: C:/xampp

Extract the files into the folder named "application-portal"
move the folder to C:/xampp/htdocs

After installing and starting XAMPP go to 
    localhost/phpmyadmin
and import the script inside 
    pplication-portal/sql

after that run the file in 
    application-portal/admin/includes/fake-account.php
to set-up your fake account for development uses

========= Before running the application. =========

Install the package manager for PHP composer
Link: https://getcomposer.org/Composer-Setup.exe

After installing composer you must navigate to application folder eg. C:/xampp/htdocs/application-portal
thru command line and copy the text below

composer install

this installs the required packages for the application so when starting the application you will not encounter any errors
open XAMPP and start the apache server. You are all set.
