<?php

namespace App\Traits;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

trait HasPermissionsTrait
{

    // -------------------------- Relationship -------------------------------------
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }


    // -------------------------- Getter -------------------------------------
    public function getPermissions()
    {
        $permissions = $this->permissions;
        foreach ($this->roles as $key => $role) {
            $permissions = $permissions->merge($role->permissions);
        }

        return $permissions;
    }



    // -------------------------- Setter -------------------------------------

    public function assignPermission($permission)
    {
        $permission = Permission::whereSlug($permission)->orWhere('id', $permission)->first();
        if ($permission) {
            if (!$this->permissions->contains($permission)) {
                $this->permissions()->attach($permission->id);
            }
        }
    }

    public function assignPermissionById($permission)
{
    $permission = Permission::find($permission) ?: Permission::where('name', $permission)->first();
    if ($permission && !$this->permissions->contains($permission)) {
        $this->permissions()->attach($permission->id);
    }
}


    public function assignRole($role)
    {
        $role = Role::whereSlug($role)->orWhere('id', $role)->first();
        if ($role) {
            if (!$this->roles->contains($role)) {
                $this->roles()->attach($role->id);
            }
        }
    }


    public function removePermission($permission)
    {
        $permission = Permission::whereSlug($permission)->orWhere('id', $permission)->first();
        if ($permission) {
            if ($this->permissions->contains($permission)) {
                $this->permissions()->detach($permission->id);
            }
        }
    }

    public function removePermissionById($permission)
    {
        $permission = Permission::find($permission) ?: Permission::where('name', $permission)->first();
        if($permission){
            if ($this->permissions->contains($permission->id)) {
                $this->permissions()->detach($permission->id);
            }
        }
         }
    

    public function removeRole($role)
    {
        $role = Role::whereSlug($role)->orWhere('id', $role)->first();
        if ($role) {
            if ($this->roles->contains($role)) {
                $this->roles()->detach($role->id);
            }
        }
    }

    public function assignPermissions(...$permissions)
    {
        foreach ($permissions as $key => $permission) {
            $this->assignPermissionById($permission);
        }
    }

    public function assignRoles(...$roles)
    {
        foreach ($roles as $key => $role) {
            $this->assignRole($role);
        }
    }

    public function removePermissions(...$permissions)
    {
        foreach ($permissions as $key => $permission) {
            $this->removePermissionById($permission);
        }
    }

    public function removeRoles(...$roles)
    {
        foreach ($roles as $key => $role) {
            $this->removeRole($role);
        }
    }

    public function resetPermissions($permissions)
    {
        $this->permissions()->detach();
        return $this->permissions()->attach($permissions);
    }

    public function resetRoles($roles)
    {
        $this->roles()->detach();
        return $this->roles()->attach($roles);
    }


    // -------------------------- Verifications -------------------------------------

    public function hasPermissionTo(...$permissions)
    {
        foreach ($permissions as $perm) {
            if ($this->may($perm)) return true;
        }
        return false;
    }

    public function may($permission)
    {
        foreach ($this->getPermissions() as $perm) {
            if ($perm->slug == $permission) return true;
        }
        return false;
    }

    public function hasPermission($permission)
    {
        return (bool) $this->getPermissions()->where('slug', $permission)->first();
    }

    public function roleHasPermission($permission)
    {
        // $this->loadMissing('roles.permissions');
        foreach ($this->roles as $role) {
            if ($role->permissions->contains('name', $permission)) {
                return true;
            }
        }
        return false;
    }

    public function hasRole($role)
    {
        if ($this->roles->name == $role || $this->roles->slug == $role) return true;
        return false;
    }
}
