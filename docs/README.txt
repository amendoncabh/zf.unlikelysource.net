README
======
2013-04-01

Chat Database Structure:
library/Zend/Queue/Adapter/Db

TO DO
=====
Lots!!!
1.  Q and A using Zend_Search_Lucene
2.  Converting Etherpad to Dojo
3.  Formatting options for Calendar
4.  Figuring out why it takes so long to load 1st time

Template
========
All $view->position_* are expected to be arrays
$view->position_1 = top menu
$view->position_7 = left column
The reason why I set it up this way is because I'm using a Joomla template for styling :-)

Setting Up Your VHOST
=====================

The following is a sample VHOST you might want to consider for your project.

<VirtualHost *:80>
   DocumentRoot "/home/zed/www/zf.unlikelysource.net/public"
   ServerName zf.unlikelysource.net

   # This should be omitted in the production environment
   SetEnv APPLICATION_ENV development

   <Directory "/home/zed/www/zf.unlikelysource.net/public">
       Options Indexes MultiViews FollowSymLinks
       AllowOverride All
       Order allow,deny
       Allow from all
   </Directory>

</VirtualHost>
