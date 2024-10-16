<?php

namespace App\Helpers;

use App\Models\User;

class RedirectHelper
{
   public static function userDashboard($user)
   {
       if ($user->hasRole('admin')) {
           return redirect('/dashboard/settings/organizations-structure');
       } else if ($user->hasRole('employee')) {
           return redirect('/dashboard/profile');
       } else if ($user->hasRole('inspector')) {
           return redirect('/dashboard/works/employees');
       } else if ($user->hasRole('platformadmin')) {
           return redirect('/dashboard/platform');
       } else {
           return redirect('/dashboard/personal-cabinet');
       }
   }
}
