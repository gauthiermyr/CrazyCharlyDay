<?php

namespace crazycharlyday\controllers;

use crazycharlyday\models\Account;
use Slim\Http\Response;
use Slim\Http\Request;

class AccountController extends Controller {

    public function getLogin(Request $request, Response $response, array $args) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $_SESSION['previousPage'] = $_SERVER['HTTP_REFERER'];
        }
        $args['title'] = 'Grande Épicerie Générale - Connexion';
        $this->container->view->render($response, 'login.phtml', $args);
        return $response;
    }

    public function postLogin(Request $request, Response $response, array $args) {
        $id = trim($_POST['id']);
        $account = Account::where('email', '=', $id)->orwhere('user', '=', $id)->first();

        if (isset($account) and password_verify($_POST['password'], $account->hash)) {
            $_SESSION['account'] = $account->toArray();
            return $this->redirect($response, 'planning');
        } else {
            $_SESSION['redirect']['msg'] = '<div class="alert alert-danger">Nom d\'utilisateur ou mot de passe incorrect, réessayez.</div>';
            $_SESSION['redirect']['username'] = $account->username;
            return $this->redirect($response, 'login');
        }
    }

}