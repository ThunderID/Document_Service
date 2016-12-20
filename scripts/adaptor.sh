#!/bin/sh
php /var/www/html/rpc_document_index.php '#'
php /var/www/html/rpc_document_store.php '#'
php /var/www/html/rpc_document_delete.php '#'
php /var/www/html/rpc_template_index.php '#'
php /var/www/html/rpc_template_store.php '#'
php /var/www/html/rpc_template_delete.php '#'
php /var/www/html/rpc_user_index.php '#'