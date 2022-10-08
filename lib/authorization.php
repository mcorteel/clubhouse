<?php

class Authorization
{
    public function isGranted($user, $role)
    {
        if($user === null) {
            return false;
        }
        
        if($role === 'user') {
            return true;
        }
        
        $roles = explode(',', (string)$user['roles']);
        
        if(in_array('super_admin', $roles)) {
            return true;
        }
        
        return in_array($role, $roles);
    }
}
