if [ ! -f .env ]; then
    cp .env.example .env
fi

if [ ! -z ${CODESPACES+x} ]; then
    SITE_URL=$(echo "https://$CODESPACE_NAME-8080.$GITHUB_CODESPACES_PORT_FORWARDING_DOMAIN" | sed 's/\//\\\//g')
    sed -i "s/SITE_URL=.*/SITE_URL=$SITE_URL/" .env
fi