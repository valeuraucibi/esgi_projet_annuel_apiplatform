### JWT auth
Installation : 
- https://api-platform.com/docs/core/jwt/#jwt-authentication
- https://github.com/lexik/LexikJWTAuthenticationBundle/blob/master/Resources/doc/index.md#getting-started
Génération d'un mdp via commande : 
```
docker-compose exec php bin/console security:encode-password
```
Connexion pour get un token JWT
```
curl -kX POST -H "Content-Type: application/json" https://localhost:8443/authentication_token -d '{"email":"ld@gmail.com","password":"password"}'
```
Utilisation du token get précédement 
```
Bearer YOUR_TOKEN_HERE
```
La commande pour loader les fixtures 
```
docker-compose exec php bin/console doctrine:fixtures:load --env=test
```
dans le fichier .env.test tu changes cette ligne PANTHER_APP_ENV=panther par PANTHER_APP_ENV=test pour loader tes fixtures

Le lien de l'api déployer sur heroku
```
https://esgiprojet-annuel-apiplatform.herokuapp.com/docs
