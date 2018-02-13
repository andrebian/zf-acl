<?php
# module/Application/src/Acl/Roles.php
namespace Application\Acl;

use Application\Controller\PostController;
use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole;

/**
 * Class Roles
 * @package Application\Acl
 */
class Roles
{
    public function __construct(Acl $acl)
    {
        $acl->addRole(new GenericRole('guest'));
        $acl->addRole(new GenericRole('premium-user'), 'guest');
        $acl->addRole(new GenericRole('admin'));
        $acl->addRole(new GenericRole('editor'));


        // role       resource                privileges
        $acl->allow('admin', PostController::class, ['add', 'edit', 'delete', 'index', 'view']);
        $acl->allow('editor', PostController::class, ['add', 'edit', 'index', 'view']);
        $acl->allow('guest', PostController::class, ['view']);
        //$acl->allow('premium-user', PostController::class, ['index','view']);
    }
}
