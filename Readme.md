# 📘 Projet Symfony - Gestion de Projets

## 🧱 Architecture

Ce projet utilise **l''architecture MVC (Modèle - Vue - Contrôleur)** avec séparation claire des responsabilités :

- **Model** : Entités Symfony ( `Project`, `User`)
- **View** : Interfaces en **Twig**
- **Controller** : Contrôleurs Symfony pour gérer les routes et les requêtes
- **Service** : Logique métier déplacée dans des services injectables via le container (`ProjectService`, etc.)

---

## ⚙️ Technologies utilisées

- **Symfony** 7.1.0
- **PHP** 8.2
- **Twig** pour les templates
- **Doctrine** ORM
- **JWT Authentication** (`lexik/jwt-authentication-bundle`)
- **Bootstrap** pour le design

---

## 📁 Structure du projet

├── config/ # Fichiers de configuration
│ ├── packages/ # Configs de bundles
│ └── routes.yaml # Définition des routes
├── public/ # Ressources publiques (images, CSS, JS)
│ └── uploads/images # Dossier pour les images de projets
├── src/
│ ├── Controller/ # Logique de gestion des requêtes
│ ├── Entity/ # Modèles de données (Project, User)
│ ├── Form/ # Fichiers pour gérer les formulaires
│ ├── Repository/ # Requêtes personnalisées
│ ├── Service/ # Logique métier séparée
│ └── Security/ # JWT & gestion de sécurité
├── templates/ # Fichiers Twig pour l’affichage
│ ├──User/ # Vues : index, show, edit, new
│ └── project/ # Vues : index, show, edit, new
├── .env # Variables d’environnement
├── composer.json # Dépendances PHP
└── README.md # Fichier explicatif (celui-ci)

---

## 🔐 Authentification

L''authentification est gérée avec **JWT** :

- Configuration dans `config/packages/lexik_jwt_authentication.yaml`
- Commandes utilisées :
  ```bash
  mkdir -p config/jwt
  openssl genrsa -out config/jwt/private.pem 4096
  openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
  ```

## ✅ Compte administrateur de test

Fixtures cres pour test avec :

- Email : admin@admin.com
- Mot de passe : admin123
  Commande :
  php bin/console doctrine:fixtures:load

## ✅ Bundles installs

- lexik/jwt-authentication-bundle
- doctrine/doctrine-fixtures-bundle
- knplabs/knp-paginator-bundle

## ✅ Résumé des fonctionnalités

Fonction Description
🔐 Authentification JWT Connexion sécurisée
🗂️ CRUD Projets Créer, afficher, modifier, supprimer
🖼️ Upload d''image Upload d''une image par projet
🔍 Pagination Pour les listes longues
🧠 Services Symfony Logique métier dans des classes dédiées
🧾 Formulaires Gestion avec FormBuilder
🧱 MVC + Twig Design et structure claire

## ✍️ Auteur

Maha laribi
