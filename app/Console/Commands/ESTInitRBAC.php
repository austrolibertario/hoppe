<?php namespace App\Console\Commands;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App;
use Illuminate\Database\Eloquent\Collection;

class ESTInitRBAC extends BaseCommand
{
    // Entrust is an RBAC library... RBAC = "Role Based Access Control"
    protected $signature = 'est:init-rbac';

    protected $description = 'Inicializar o controle de acesso baseado em função';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $user = User::first();
        if (!$user) {
            $this->error("A tabela de usuários está vazia");
            return;
        }
        $founder     = Role::addRole('Founder', 'Fundador');
        $maintainer  = Role::addRole('Maintainer', 'Mantenedor');
        $contributor = Role::addRole('Contributor', 'Contribuidor');

        $visit_admin   = Permission::addPermission('visit_admin', 'Entrar na Administração');
        $manage_users  = Permission::addPermission('manage_users', 'Manusear Usuários');
        $manage_topics = Permission::addPermission('manage_topics', 'Manusear Tópicos');
        $compose_announcement = Permission::addPermission('compose_announcement', 'Compondo Anúncio');
        $access_board = Permission::addPermission('access_board', 'Acessar Boards');

        $this->attachPermissions($founder, [
            $visit_admin,
            $manage_users,
            $manage_topics,
            $compose_announcement,
            $access_board,
        ]);

        $this->attachPermissions($maintainer, [
            $visit_admin,
            $manage_topics,
            $compose_announcement,
        ]);

        if (!$user->hasRole($founder->name)) {
            $user->attachRole($founder);
        }

        $this->info('--');
        $this->info("Inicializando com sucesso o RBAC -- ID: 1 e Nome “{$user->name}” tem permissão de fundador");
        $this->info('--');

        for($i=2;$i<=7;$i++) {
            $user = User::find($i);
            if (!$user->hasRole($founder->name)) {
                $user->attachRole($founder);
            }
            $this->info('--');
            $this->info("Inicializando com sucesso o RBAC -- ID: $i e Nome “{$user->name}” tem permissão de fundador");
            $this->info('--');
        }

        // Autores
        for($i=8;$i<=10;$i++) {
            $user = User::find($i);
            if (!$user->hasRole($founder->name)) {
                $user->attachRole($founder);
            }
            $this->info('--');
            $this->info("Inicializando com sucesso o RBAC -- ID: $i e Nome “{$user->name}” tem permissão de “{$founder->name}”");
            $this->info('--');
        }
    }

    /**
     * @param Role         $role
     * @param Permission[] $permissions
     */
    public function attachPermissions(Role $role, array $permissions)
    {
        $attach = [];

        $permissions = new Collection($permissions);

        $detach = [];
        foreach ($role->perms()->get() as $permission) {
            if ($permissions->where('name', $permission->name)->isEmpty()) {
                $detach[] = $permission;
            }
        }

        foreach ($permissions as $permission) {
            if (!$role->hasPermission($permission->name)) {
                $attach[] = $permission;
            }
        }

        $role->detachPermissions($detach);
        $role->attachPermissions($attach);
    }
}
