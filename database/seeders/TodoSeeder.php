<?php

namespace Database\Seeders;

use App\Models\Todo;
use Illuminate\Database\Seeder;

class TodoSeeder extends Seeder
{
    public function run(): void
    {
        $todos = [
            [
                'title' => 'Complete Laravel project',
                'description' => 'Finish building the modern todo application with responsive design',
                'priority' => 'high',
                'due_date' => now()->addDays(3),
                'completed' => false
            ],
            [
                'title' => 'Review code',
                'description' => 'Review the codebase for best practices and optimization',
                'priority' => 'medium',
                'due_date' => now()->addDays(1),
                'completed' => false
            ],
            [
                'title' => 'Update documentation',
                'description' => 'Update project documentation and README file',
                'priority' => 'low',
                'due_date' => now()->addWeek(),
                'completed' => true
            ],
            [
                'title' => 'Deploy to production',
                'description' => 'Deploy the application to production server',
                'priority' => 'high',
                'due_date' => now()->addDays(5),
                'completed' => false
            ]
        ];

        foreach ($todos as $todo) {
            Todo::create($todo);
        }
    }
}
