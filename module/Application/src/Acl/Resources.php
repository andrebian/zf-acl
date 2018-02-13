<?php
# module/Application/src/Acl/Resources.php
namespace Application\Acl;

use Application\Controller\PostController;
use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Resource\GenericResource;

/**
 * Class Resources
 * @package Application\Acl
 */
class Resources
{
    public function __construct(Acl $acl)
    {
        $acl->addResource(new GenericResource(PostController::class));
    }
}
