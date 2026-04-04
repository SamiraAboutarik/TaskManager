<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $tasks = [
            [
                'title'       => 'Configurer l\'environnement Laravel',
                'description' => 'Installer et configurer Laravel avec XAMPP, Composer et les dépendances nécessaires.',
                'status'      => 'done',
                'due_date'    => now()->subDays(10),
            ],
            [
                'title'       => 'Créer la migration de la table tasks',
                'description' => 'Définir les champs : id, title, description, status, due_date, timestamps.',
                'status'      => 'done',
                'due_date'    => now()->subDays(8),
            ],
            [
                'title'       => 'Implémenter le CRUD des tâches',
                'description' => 'Créer les opérations Create, Read, Update et Delete avec Eloquent.',
                'status'      => 'done',
                'due_date'    => now()->subDays(6),
            ],
            [
                'title'       => 'Ajouter la validation des formulaires',
                'description' => 'Utiliser un FormRequest pour valider title (min 3), status et due_date.',
                'status'      => 'done',
                'due_date'    => now()->subDays(5),
            ],
            [
                'title'       => 'Concevoir l\'interface utilisateur',
                'description' => 'Créer les vues Blade avec Bootstrap 5 : liste, formulaire création, formulaire édition.',
                'status'      => 'in_progress',
                'due_date'    => now()->addDays(1),
            ],
            [
                'title'       => 'Implémenter le filtrage par statut',
                'description' => 'Permettre à l\'utilisateur de filtrer les tâches par : todo, in_progress, done.',
                'status'      => 'in_progress',
                'due_date'    => now()->addDays(2),
            ],
            [
                'title'       => 'Ajouter la pagination',
                'description' => 'Paginer les résultats avec 10 tâches par page en conservant les filtres actifs.',
                'status'      => 'in_progress',
                'due_date'    => now()->addDays(3),
            ],
            [
                'title'       => 'Implémenter la recherche par titre',
                'description' => 'Ajouter une barre de recherche qui filtre les tâches en temps réel.',
                'status'      => 'todo',
                'due_date'    => now()->addDays(4),
            ],
            [
                'title'       => 'Ajouter le bouton "Marquer comme terminé"',
                'description' => 'Un seul clic pour passer une tâche au statut done directement depuis la liste.',
                'status'      => 'todo',
                'due_date'    => now()->addDays(5),
            ],
            [
                'title'       => 'Rédiger la documentation du projet',
                'description' => 'Documenter l\'installation, les routes, les choix techniques et les fonctionnalités.',
                'status'      => 'todo',
                'due_date'    => now()->addDays(6),
            ],
            [
                'title'       => 'Faire la revue de code (code review)',
                'description' => 'Vérifier la lisibilité, les conventions de nommage et la qualité du code avant soumission.',
                'status'      => 'todo',
                'due_date'    => now()->addDays(7),
            ],
            [
                'title'       => 'Tester toutes les fonctionnalités',
                'description' => 'Tester manuellement chaque fonctionnalité : CRUD, filtres, validations, messages flash.',
                'status'      => 'todo',
                'due_date'    => now()->addDays(8),
            ],
        ];

        foreach ($tasks as $task) {
            Task::create($task);
        }
    }
}
