FROM alpine:3.12
RUN apk update
RUN apk add php7 php-curl php-phar php7-iconv php7-ctype php7-mbstring php7-dom php7-session php7-json php7-openssl php7-xml

COPY . /app

ENTRYPOINT ["/bin/sh"]
