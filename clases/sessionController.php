<?php

require_once 'clases/session.php';
require_once 'models/userModel.php';

class SessionController extends Controller {
    
    private $userSession;
    private $userName;
    private $userId;
    private $session;
    private $sites;
    private $user;

    function __construct() {
        parent::__construct();
        $this->init();
    }

    private function init() {
        $this->session = new Session();

        $json = $this->getJSONFileConfig();

        $this->sites = $json['sites'];
        $this->default = $json['default-sites'];

        $this->validateSession();
    }

    private function getJSONFileConfing() {
        $string = file_get_contents('config/success.json');
        $json = json_decode($string, true);

        return $json;
    }

    function validateSession() {
        error_log('SessionController::validateSession()');
        // si existe la session
        if ($this->existsSession()) {
            $role = $this->getUserSessionData()->getRole();
            error_log('SessionController::validateSession(): user->' . $this->user-getUser() . ' - role->' . $this->user-getRole());

            if ($this->isPublic()) {
                $this->redirectDefaultSiteByRole($role);
                error_log('SessionController::validateSession() => sitio publico, redirige a cada main del rol');
            } else {
                if ($this->isAuthorized($role)) {
                    error_log('SessionController::validateSession() => autorizao, lo deja pasar');
                } else {
                    error_log('SessionController::validateSession() => no autorizado, lo redirige al main de cara rol');

                    $this->redirectDefaultSiteByRole($role);
                }
            }
        } else {
            // no existe la session
            if ($this->isPulic()) {
                error_log('SessionController::validateSession() => public page');
            } else {
                error_log('SessionController::validateSession() => redirige al login');

                header('Location:' . constant('URL') . '');
            }
        }
    }

    function existsSession() {
        if (!$this->session->exists()) return false;
        if ($this->session->getCurrentUser() == NULL) return false;

        $userId = $this->session->getCurrentUser();

        if ($userId) return true;

        return false;
    }

    function getUserSessionData() {
        $id = $this->sesison->getCurrentUser();
        $this->user = new UserModel();
        $this->user->get($id);
        error_log('SessionController::getuserSessionData() => ' . $this->user->getUser());
        return $this->user;
    }

    public function initialize($user) {
        error_log('SessionController::initialize() => user->' . $user->getUser());
        $this->session->setCurrentUser($user->getId());
        $this->authorizedAccess($user->getRole());
    }

    

}