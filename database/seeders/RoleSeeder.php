<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * Create three roles: admin, teacher, and parent. Each role has a name and a description.
         * The admin role is assigned all permissions, while the teacher and parent roles are assigned
         * specific subsets of permissions based on their responsibilities. The teacher role is given
         * permissions related to creating evaluations, editing evaluations, grading students, and taking
         * attendance. The parent role is given permissions to view grades, view attendance, and view
         * observations. This seeding process ensures that the necessary roles and their associated
         * permissions are available in the database for use in the application.
         */
        $admin = Role::create([
            'name' => 'Admin',
            'description' => 'Administrador'
        ]);

        $teacher = Role::create([
            'name' => 'Teacher',
            'description' => 'Profesor'
        ]);

        $parent = Role::create([
            'name' => 'Parent',
            'description' => 'Padre'
        ]);
        $admin->permissions()->sync(Permission::all());

        $teacher->permissions()->sync(
            Permission::whereIn('name', [
                'create_evaluations',
                'edit_evaluations',
                'grade_students',
                'take_attendance'
            ])->pluck('id')
        );

        $parent->permissions()->sync(
            Permission::whereIn('name', [
                'view_grades',
                'view_attendance',
                'view_observations'
            ])->pluck('id')
        );
    }
}
