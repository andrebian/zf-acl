<?php
# module/Application/src/Controller/PostController.php
namespace Application\Controller;

use Application\Acl\Resources;
use Application\Acl\Roles;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole;
use Zend\View\Model\ViewModel;

class PostController extends AbstractActionController
{
    public function indexAction()
    {
        // o privilégio do recurso PostController (index)
        $privilege = str_replace('Action', '',__FUNCTION__);

        // Chamando nosso Acl
        $acl = new Acl();

        /*
         * Carregando as configurações de resources, roles e privileges.
         *
         * A ordem tem que ser esta, recursos primeiro e roles depois senão, no
         * momento de registrar os privilégios um erro será lançado informando que
         * o recurso não existe.
         */
        (new Resources($acl));
        (new Roles($acl));

        // para fins de exemplo, definindo todos os roles.
        $admin = 'admin';
        $editor = new GenericRole('editor');
        $guest = new GenericRole('guest');

        // e verificando um a um se possui acesso ao recurso com o devido privilégio
        $messageAdmin = $privilege . ': Acesso negado para admin';
        if ($acl->isAllowed($admin, __CLASS__, $privilege)) {
            $messageAdmin = $privilege . ': Acesso garantido para admin';
        }
        var_dump($messageAdmin);

        $messageEditor = $privilege . ': Acesso negado para editor';
        if ($acl->isAllowed($editor, __CLASS__, $privilege)) {
            $messageEditor = $privilege . ': Acesso garantido para editor';
        }
        var_dump($messageEditor);

        $messageGuest = $privilege . ': Acesso negado para guest';
        if ($acl->isAllowed($guest, __CLASS__, $privilege)) {
            $messageGuest = $privilege . ': Acesso garantido para guest';
        }
        var_dump($messageGuest);

        $message = $privilege . ': Acesso negado para premium user';
        if ($acl->isAllowed('premium-user', __CLASS__, $privilege)) {
            $message = $privilege . ': Acesso garantido para Premium user';
        }
        var_dump($message);
        
        if (!$acl->isAllowed('premium-user', __CLASS__, $privilege)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('Acesso não autorizado');
            return $this->redirect()->toRoute('home');
        }

        return new ViewModel();
    }
}