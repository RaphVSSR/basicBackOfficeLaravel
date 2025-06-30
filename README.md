<h1 align="center" style="margin: 30px auto; font-size: 42px;">Basic Back-Office Laravel</h1>

<div align="center">
   <img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/php/php-original.svg" title="PHP" alt="PHP" width="40" height="40"/>&emsp;
   <img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/laravel/laravel-original.svg" title="Laravel" alt="Laravel" width="40" height="40"/>&emsp;
   <img src="https://avatars.githubusercontent.com/u/15017015?s=48&v=4" title="Backpack" alt="Backpack" width="40" height="40"/>&emsp;
   <img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/vitejs/vitejs-original.svg" title="Vite" alt="Vite" width="40" height="40"/>&emsp;
   <img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/mysql/mysql-original.svg" title="MySQL" alt="MySQL" width="40" height="40"/>
</div>
<br>

## 📖 Présentation

Ce projet est une application web conçue pour servir de point de départ robuste pour tout projet nécessitant une gestion de contenu simple et efficace.

Il fournit une base solide combinant un site vitrine élégant pour présenter des produits et un panneau d'administration complet, propulsé par Backpack. La partie publique permet aux visiteurs de consulter des articles et de les filtrer par catégories, tandis que l'espace administrateur offre une gestion intuitive (CRUD) des articles, catégories, utilisateurs et permissions.

C'est la solution idéale pour lancer rapidement un catalogue en ligne, un portfolio ou un mini-site e-commerce.

<br>

## ✨ Fonctionnalités

### Site Public (Front-end)
- **Affichage des Articles** : Grille de produits avec image, nom, catégorie et prix.
- **Filtrage par Catégories** : Barre de navigation permettant de n'afficher que les produits d'une catégorie.
- **Accès à l'administration** :
    - Un bouton "S'identifier" mène à la page de connexion.
    - Une fois connecté, ce bouton est remplacé par le nom de l'utilisateur, qui mène directement au **Dashboard** de l'espace admin.

### Panneau d'Administration (Back-end)
- **Gestion des Articles** : CRUD complet (Créer, Lire, Mettre à jour, Supprimer).
- **Gestion des Catégories** : CRUD complet.
- **Gestion des Utilisateurs & Rôles** : CRUD complet, avec attribution de permissions via Spatie/Permission.

<br>

## 🚀 Guide d'Installation

### 1. Dépendances & Fichiers Manquants

**Important** : Le fichier `.env` n'est pas inclus dans le projet pour des raisons de sécurité. Vous devez le créer vous-même.

1.  **Cloner le projet**
    ```bash
    git clone <URL_DU_REPOSITORY>
    cd basicBackOfficeLaravel
    ```

2.  **Installer les dépendances PHP**
    ```bash
    composer install
    ```

3.  **Créer et configurer le fichier d'environnement**
    Copiez le fichier d'exemple `.env.example` et renommez la copie en `.env`.
    ```bash
    cp .env.example .env
    ```
    Générez ensuite la clé d'application unique.
    ```bash
    php artisan key:generate
    ```

4.  **Installer les dépendances Front-end**
    ```bash
    npm install
    ```
<br>

### 2. Importer la Base de Données

Ce projet est fourni avec une base de données pré-configurée incluant la structure des tables et des données de démonstration.

1.  **Mettez à jour le fichier `.env`**
    Ouvrez le fichier `.env` et assurez-vous que les informations de connexion à la base de données correspondent à votre environnement local. Le nom de la base de données attendu par le fichier SQL est `laravelbackpack`.
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravelbackpack # <-- Nom important
    DB_USERNAME=root # Votre utilisateur, souvent 'root' en local
    DB_PASSWORD= # Votre mot de passe, souvent vide en local
    ```

2.  **Importez le fichier SQL**
    - Créez une base de données nommée `laravelbackpack` dans votre outil de gestion (phpMyAdmin, TablePlus, etc.).
    - Importez le fichier `database/dbToInjectInMyAdmin.sql` dans cette base de données.
    
    **Cette action créera toutes les tables nécessaires, les rôles et des exemples de contenu.** Vous n'avez PAS besoin de lancer `php artisan migrate`.

### 3. Lancer le site

Lancez le serveur de développement qui s'occupera des assets (Vite) et du serveur PHP.

```bash
npm run dev
```

Votre site est maintenant accessible à l'adresse `http://127.0.0.1:8000`.
<br>

## 🔧 Personnalisation & Espace Admin

### Accès Administrateur

Le fichier SQL importé contient déjà un utilisateur avec des accès. Pour vous connecter, utilisez les identifiants que vous trouverez dans la table `users` de votre base de données. Vous pouvez également en créer un nouveau.

Cliquez sur le bouton **"S'identifier"** en haut à droite de la page d'accueil pour accéder au panneau d'administration.

### Conseils de Personnalisation
- **Thème visuel** : Les couleurs et polices sont définies dans `resources/css/app.css` et `tailwind.config.js`. Vous pouvez les modifier pour adapter le site à votre identité.
- **Contenus CRUD** : L'essentiel de la logique de l'administration se trouve dans `app/Http/Controllers/Admin/`. Vous pouvez y modifier les champs, colonnes et filtres pour les Articles, Catégories et Utilisateurs.
- **Modèles de données** : Les modèles Eloquent (`app/Models/Articles.php`, etc.) définissent les relations et les attributs des données.


## 📜 Licence

Ce projet est distribué sous la **Licence MIT**. Voir le fichier `LICENSE` pour plus de détails.