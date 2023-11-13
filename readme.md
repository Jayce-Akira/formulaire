# le formulaire de contact


## Environnement de développement

### Pré-requis

* Symfony 6.3
* PHP 8.2
* Composer
* Symfony CLI
* nodejs et npm

Vous pouvez vérifier les pré-requis avec la commande suivante (de la CLI Symfony) :

```bash
symfony check:requirement
```
### Lancer l'environnement de développement

bien vérifier si le fichier .env est bien dans votre environnement
Ne pas hésiter à la modifier

```bash
composer install
npm install
npm run build
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
symfony server:start -d
```

### Mise en place de l'envoie MAIL

Fait avec MAILtrap bien mettre son DSN dans l'.env