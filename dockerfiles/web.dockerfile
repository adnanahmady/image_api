FROM nginx:1.14
COPY vhost.conf /etc/nginx/conf.d/default.conf