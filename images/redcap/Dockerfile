FROM php:8.0.5-apache
 
MAINTAINER Robert Reihs "robert.reihs@medunigraz.at"
 
# Install requert packages for php
# Install msmtp for mail sending
 
RUN apt-get update && \
   apt-get install -y \
   libzip-dev \ 
   msmtp && \
   docker-php-ext-install mysqli && \
   docker-php-ext-install zip && \
   apt-get clean && \
   rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
   find /var/log -type f | while read f; do echo -ne '' > $f; done;
   
CMD ["exec apache2-foreground"]
