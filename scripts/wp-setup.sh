#!/bin/bash

# A simple retry mechanism
for i in {1..20}
do
    wp core install \
        --url="${SITE_URL}" \
        --title="${SITE_TITLE}" \
        --admin_user="${SITE_ADMIN_USER}" \
        --admin_password="${SITE_ADMIN_PASSWORD}" \
        --admin_email="${SITE_ADMIN_EMAIL}" && \
    wp plugin activate mailtrap && \
    wp rewrite structure '/%postname%/' && \
    wp plugin delete hello && \
    wp plugin delete akismet && break || sleep 5;
done

# Keep alive
tail -f /dev/null