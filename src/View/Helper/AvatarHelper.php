<?php
namespace App\View\Helper;

use Cake\View\Helper;

class AvatarHelper extends Helper
{
    public function display($user, $size = 40)
    {
        $avatarUrl = $user->avatar ? 
            '/img/users/' . $user->avatar : 
            '/img/users/default.png';
            
        return sprintf(
            '<div class="avatar-circle" style="width: %spx; height: %spx; background-image: url(\'%s\')"></div>',
            $size,
            $size,
            $avatarUrl
        );
    }
}
