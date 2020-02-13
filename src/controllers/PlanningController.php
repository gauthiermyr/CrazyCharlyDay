<?php

namespace crazycharlyday\controllers;
use crazycharlyday\models\Creneau;
use crazycharlyday\models\Poste;
use Slim\Exception\NotFoundException;
use Slim\Http\Response;
use Slim\Http\Request;
use Slim\Views\PhpRenderer;

class PlanningController extends Controller
{

    public function displayPlanning(Request $request, Response $response, array $args){
        $this->container->view->render($response, 'planning.phtml', $args);
    }

    public function getCreneau(Request $request, Response $response, array $args){
        //$creneau = Creneau::where('id','=',$args['id'])->first();
        $postes = Poste::where('creneau','=',$args['id'])->get();
        //var_dump($postes);
        //$args['postes'] = $postes;
        $rootUri = $request->getUri()->getBasePath();
        echo
  <<<END
    <link rel="stylesheet" href="$rootUri/public/css/bootstrap.css">
<table class="table" id="creneau">
    <thead class="thead-dark">
    <tr>
        <th scope="col">Rôle</th>
        <th scope="col">Personne</th>
    </tr>
    </thead>
    <tbody>
END;
        foreach ($postes as $poste) {
            $role = $poste->role;
            $idcompte = $poste->idCompte;
            if ($idcompte == null) {
                $text = "S'inscrire";
            } else {
                $text = $idcompte;
            }
            echo
            <<<END
            <tr>
                <th scope="row">$role</th>
                    <td>$text</td>
            </tr>
END;
        }
        echo
        <<<END
    </tbody>
</table>
END;


    }



}