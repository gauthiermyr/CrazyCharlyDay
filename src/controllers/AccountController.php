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
            $_SESSION['login'] = ['email' => $account->email, 'username' => $account->user,
                'prenom' => $account->prenom, 'nom' => $account->nom, 'admin' => $account->admin];
            return $this->redirect($response, 'planning');
        } else {
            $_SESSION['redirect']['msg'] = '<div class="alert alert-danger">Nom d\'utilisateur ou mot de passe incorrect, réessayez.</div>';
            $_SESSION['redirect']['username'] = $account->username;
            return $this->redirect($response, 'login');
        }
    }

    public function displayUsers(Request $request, Response $response, array $args){
        $accounts = Account::select('*')->get();
        $args['accounts'] = $accounts;
        $this->container->view->render($response, 'members.phtml', $args);
        return $response;
    }

    public function getInscription(Request $request, Response $response, array $args) {
        $args['title'] = 'Grande Épicerie Générale - Inscription d\'un participant';
        $this->container->view->render($response, 'inscription.phtml', $args);
        return $response;
    }

    public function postInscription(Request $request, Response $response, array $args) {
        $account = new Account();
        $account->user = trim($_POST['user']);
        $account->hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $account->email = trim($_POST['email']);
        $account->nom = trim($_POST['nom']);
        $account->prenom = trim($_POST['prenom']);

        $account->save();

        $_SESSION['login'] = ['email' => $account->email, 'username' => $account->user,
            'prenom' => $account->prenom, 'nom' => $account->nom];

        return $this->redirect($response, 'planning');
    }

    public function getLogout(Request $request, Response $response, array $args) {
        unset($_SESSION['login']);
        return $this->redirect($response, 'login');
    }

    public function getCompte(Request $request, Response $response, array $args) {
        if (isset($_SESSION['login'])) {
            $account = Account::where('user', '=', $_SESSION['login']['username'])->first();
            $args['account'] = $account;
        }
        $args['title'] = 'Grande Épicerie Générale - Compte';
        $this->container->view->render($response, 'compte.phtml', $args);
        return $response;
    }

    public function postEditAccount(Request $request, Response $response, array $args) {
        $account = Account::where('user', '=', $_SESSION['login']['username'])->first();

        if ($account->email != $_POST['email'] || $account->prenom != $_POST['prenom'] || $account->nom != $_POST['nom']) {
            $account->email = trim($_POST['email']);
            $account->prenom = trim($_POST['prenom']);
            $account->nom = trim($_POST['nom']);
            $account->save();

            unset($_SESSION['login']);
            $_SESSION['login'] = ['email' => $account->email, 'username' => $account->user, 'prenom' => $account->prenom, 'nom' => $account->nom];
            $_SESSION['redirect']['msg'] = '<div class="alert alert-success">Les modifications ont bien été enregistrées.</div>';
        }
        return $this->redirect($response, 'account');
    }

    public function postChangePassword(Request $request, Response $response, array $args) {
        $account = Account::where('user', '=', $_SESSION['login']['username'])->first();
        if (password_verify($_POST['oldPassword'], $account->hash)) {
            $account->hash = password_hash($_POST['newPassword'], PASSWORD_DEFAULT);
            $account->save();

            $_SESSION['redirect']['msg'] = '<div class="alert alert-success">Le mot de passe a bien été modifié.</div>';
            $_SESSION['redirect']['username'] = $account->username;
            return $this->redirect($response, 'account');
        } else {
            $_SESSION['redirect']['msg'] = '<div class="alert alert-danger">Ancien mot de passe incorrect, réessayez.</div>';
            return $this->redirect($response, 'account');
        }
    }

    public function postDeleteAccount(Request $request, Response $response, array $args) {
        $account = Account::where('user', '=', $_SESSION['login']['username'])->first();
        if (password_verify($_POST['password'], $account->hash)) {
            $account->delete();
            unset($_SESSION['login']);
            $_SESSION['redirect']['msg'] = '<div class="alert alert-success">Votre compte a bien été supprimé.</div>';
            return $this->redirect($response, 'login');
        } else {
            $_SESSION['redirect']['msg'] = '<div class="alert alert-danger">Mot de passe incorrect, réessayez.</div>';
            return $this->redirect($response, 'inscription');
        }
    }
}