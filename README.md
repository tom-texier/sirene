# Mini API Sirène
### Créer une interface web avec une micro API permettant de retrouver une entreprise grâce à son SIRET ou grâce à son nom. Pour cela vous utiliserez l’api SIRÈNE comme source d'information.

[![Symfony Badge](https://img.shields.io/badge/Symfony-5.4-000000?style=flat-square&logo=symfony&logoColor=white/)](https://symfony.com/)
[![Twig Badge](https://img.shields.io/badge/Twig-3.8-bacf29?style=flat-square&logo=symfony&logoColor=white/)](https://twig.symfony.com/)
[![Composer Badge](https://img.shields.io/badge/Composer-2.5.5-6c3e22?style=flat-square&logo=composer&logoColor=white/)](https://getcomposer.org/)
[![PHP Badge](https://img.shields.io/badge/PHP-7.4-7a86b8?style=flat-square&logo=php&logoColor=white/)](https://www.php.net/)
![HTML5 Badge](https://img.shields.io/badge/HTML-5-e34f26?style=flat-square&logo=html5&logoColor=white/)
![CSS3 Badge](https://img.shields.io/badge/CSS-3-1572B6?style=flat-square&logo=css3&logoColor=white/)
[![Node Badge](https://img.shields.io/badge/Node-14.21.3-339933?style=flat-square&logo=Node.js&logoColor=white/)](https://nodejs.org/fr/)

## Prérequis d'installation
Pour initialiser le projet, vous devrez avoir installé sur votre machine (les versions utilisées pour le projet sont indiquées ci-dessus) :
- Composer
- Node.js
- PHP
- Symfony CLI *(optionnelle)*

## Installation

1. Cloner le projet à l'emplacement de votre choix
```shell
git clone https://github.com/tom-texier/sirene.git
```

2. Se déplacer à la racine du projet
```shell
cd sirene
```

3. Installer les dépendances Composer
```shell
composer install
```

4. Installer les packages
```shell
npm install
```

5. Ajouter le token de l'API SIRÈNE dans le fichier `.env` à la racine du projet
```dotenv
SIRENE_TOKEN=XXXXXXXXXXXXXXXXXXXXX
```

6. Démarrer l'application
```shell
php -S localhost:8000 -t public
```
ou
```shell
symfony server:start
```

7. La console vous indiquera l'URL à suivre pour se rendre sur l'application