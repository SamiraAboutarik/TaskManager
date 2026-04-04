# TaskFlow – Laravel Task Manager

**Projet PFE | Test Laravel | OFPPT Aït Melloul**

---

## Stack technique

| Couche    | Technologie         |
|-----------|---------------------|
| Backend   | Laravel 10 / PHP 8.2|
| Frontend  | Blade + Bootstrap 5 |
| BDD       | MySQL (XAMPP)       |
| Icônes    | Bootstrap Icons     |
| Fonts     | Google Fonts (DM Sans + Syne) |

---

## Installation

```bash
# 1. Cloner / extraire le projet
cd C:/xampp/htdocs
git clone <repo> taskflow
cd taskflow

# 2. Dépendances
composer install

# 3. Fichier environnement
cp .env.example .env
php artisan key:generate

# 4. Base de données (créer "taskflow" dans phpMyAdmin d'abord)
# Dans .env :
DB_DATABASE=taskflow
DB_USERNAME=root
DB_PASSWORD=

# 5. Migration + Seed
php artisan migrate --seed

# 6. Lancer le serveur
php artisan serve
```

Accéder sur : **http://localhost:8000**

---

## Structure du projet

```
app/
├── Http/
│   ├── Controllers/
│   │   └── TaskController.php      ← CRUD complet + filtrage
│   └── Requests/
│       └── TaskRequest.php         ← Validation centralisée
└── Models/
    └── Task.php                    ← Eloquent model + scopes + helpers

database/
├── migrations/
│   └── ..._create_tasks_table.php  ← Structure BDD
└── seeders/
    ├── DatabaseSeeder.php
    └── TaskSeeder.php              ← 12 tâches de test

resources/views/
├── layouts/
│   └── app.blade.php               ← Layout principal
└── tasks/
    ├── index.blade.php             ← Liste + filtres + pagination
    ├── create.blade.php            ← Formulaire création
    ├── edit.blade.php              ← Formulaire édition
    └── _form.blade.php             ← Formulaire partagé (DRY)

routes/
└── web.php                         ← Routes resource + route bonus
```

---

## Fonctionnalités

### Backend ✅
- Migration avec tous les champs requis (`id`, `title`, `description`, `status`, `due_date`, `timestamps`)
- CRUD complet via `TaskController` (resource controller)
- `TaskRequest` : validation centralisée avec messages en français
  - `title` : requis, min 3 chars, max 255
  - `status` : requis, enum (`todo`, `in_progress`, `done`)
  - `due_date` : optionnel, date valide
- Filtrage par statut via query scope `scopeByStatus()`
- Recherche par titre via query scope `scopeSearch()`
- 12 tâches seedées avec `TaskSeeder`

### Frontend ✅
- Affichage en tableau responsive avec Bootstrap 5
- Formulaire création (avec validation errors)
- Formulaire édition (pré-rempli, DRY via `_form.blade.php`)
- Suppression avec confirmation JS
- Filtrage par statut (cards cliquables)
- Messages flash (succès/erreur)
- Erreurs de validation clairement affichées

### Bonus ✅
- Recherche par titre
- Pagination (10 tâches/page, conserve les filtres)
- Bouton "Marquer comme terminé" en un clic (PATCH)
- Indicateur "En retard" si `due_date` dépassée et statut ≠ done
- Interface sombre et soignée (dark theme)
- Responsive mobile

---

## Routes

| Méthode   | URL                    | Nom            | Action           |
|-----------|------------------------|----------------|------------------|
| GET       | /tasks                 | tasks.index    | Liste + filtres  |
| GET       | /tasks/create          | tasks.create   | Formulaire créer |
| POST      | /tasks                 | tasks.store    | Enregistrer      |
| GET       | /tasks/{id}/edit       | tasks.edit     | Formulaire éditer|
| PUT       | /tasks/{id}            | tasks.update   | Mettre à jour    |
| DELETE    | /tasks/{id}            | tasks.destroy  | Supprimer        |
| PATCH     | /tasks/{id}/done       | tasks.done     | Marquer terminé  |

---

## Choix techniques

**FormRequest** : j'ai préféré isoler la validation dans `TaskRequest` plutôt que de la mettre directement dans le contrôleur, pour garder le contrôleur léger et respecter le principe Single Responsibility.

**Query Scopes** : les scopes `byStatus()` et `search()` dans le model permettent de composer les requêtes proprement sans dupliquer la logique SQL.

**Partial `_form.blade.php`** : le formulaire est extrait dans un partial réutilisé par `create.blade.php` et `edit.blade.php` pour respecter le principe DRY.

**`withQueryString()`** : la pagination préserve automatiquement les paramètres de filtrage et recherche dans l'URL.

---

## Auteur

**Samirra** – Étudiante en Développement Digital (Full Stack), OFPPT Aït Melloul
