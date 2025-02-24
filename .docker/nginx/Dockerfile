FROM nginx:latest

ADD conf.d/default.conf /etc/nginx/conf.d/default.conf
ADD certs/server.crt /etc/nginx/certs/cert.crt
ADD certs/server.key /etc/nginx/certs/cert.key

RUN mkdir -p /var/www/html
