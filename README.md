# SSO
Steps
- cd laradock
- docker-compose up -d nginx mysql phpmyadmin
- sudo vim /etc/hosts
- add 
  127.0.0.1 customer.local
  127.0.0.1 server.local
  127.0.0.1 cms.local
- docker-compose exec workspace bash
- cd ssoc
- edit database info in .env
- cd ssocms
- edit database info in .env
- cd ssos
- edit database info in .env
- php artisan migrate --seed
- on browser, access customer.local or cms.local
