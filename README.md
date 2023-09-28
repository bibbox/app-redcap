# redcap BIBBOX application

This container can be installed as [BIBBOX APP](https://bibbox.readthedocs.io/en/latest/ "BIBBOX App Store") or standalone. 

After the docker installation follow these [instructions](INSTALL-APP.md).

## Standalone Installation 

Clone the github repository. If necessary change the ports in the environment file `.env` and the volume mounts in `docker-compose.yml`.

```
git clone https://github.com/bibbox/app-redcap
cd app-redcap
docker network create bibbox-default-network
docker-compose up -d
```

The main App can be opened and set up at:
```
http://localhost:8096
```

## Install within BIBBOX

Visit the BIBBOX page and find the App by its name in the store. Click on the symbol and select install. Then fill the parameters below and name your App, click install again.

## Docker Images used
  - [mariadb](https://hub.docker.com/r/mariadb) 
  - [bibbox/redcap](https://hub.docker.com/r/bibbox/redcap) 
  - [adminer](https://hub.docker.com/r/adminer) 


 
## Install Environment Variables
  - MYSQL_ROOT_PASSWORD = ROOT Password for MySQL DB, please change for production
  - MYSQL_DATABASE = Database name for redcap database in MySQL
  - MYSQL_USER = Username for MySql
  - MYSQL_PASSWORD = Password for MySQL DB, please change for production

  
The default values for the standalone installation are:
  - MYSQL_ROOT_PASSWORD = changethispasswordinproductionenvironments
  - MYSQL_DATABASE = redcap
  - MYSQL_USER = redcap
  - MYSQL_PASSWORD = redcap4bibbox

  
## Mounted Volumes
### mariadb Conatiner
  - *./data/mysql:/var/lib/mysql*
  - *./data/config/mariadb.cnf:/etc/mysql/conf.d/mariadb.cnf*
### bibbox/redcap Conatiner
  - *./data/html:/var/www/html*
  - *./data/user-uploaded-documents:/opt/uploads*
  - *./data/config/php-extensin.ini:/usr/local/etc/php/conf.d/php-extensin.ini*
  - *./data/config/msmtprc:/etc/msmtprc*

