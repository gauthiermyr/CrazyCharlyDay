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
        $cycle = 0;
        //TODO cycle
        $creneaux_lundis = Creneau::where('semaine','=',$args['semaine'])->where('jour','=',1)->where('cycle','=',$cycle)->orderBy('heureD')->get();
        $creneaux_mardis = Creneau::where('semaine','=',$args['semaine'])->where('jour','=',2)->where('cycle','=',$cycle)->orderBy('heureD')->get();
        $creneaux_mercredis = Creneau::where('semaine','=',$args['semaine'])->where('jour','=',3)->where('cycle','=',$cycle)->orderBy('heureD')->get();
        $creneaux_jeudis = Creneau::where('semaine','=',$args['semaine'])->where('jour','=',4)->where('cycle','=',$cycle)->orderBy('heureD')->get();
        $creneaux_vendredis = Creneau::where('semaine','=',$args['semaine'])->where('jour','=',5)->where('cycle','=',$cycle)->orderBy('heureD')->get();
        $creneaux_samedis = Creneau::where('semaine','=',$args['semaine'])->where('jour','=',6)->where('cycle','=',$cycle)->orderBy('heureD')->get();
        $creneaux_dimanches = Creneau::where('semaine','=',$args['semaine'])->where('jour','=',7)->where('cycle','=',$cycle)->orderBy('heureD')->get();

        $args['lundis'] = $creneaux_lundis;
        $args['mardis'] = $creneaux_mardis;
        $args['mercredis'] = $creneaux_mercredis;
        $args['jeudis'] = $creneaux_jeudis;
        $args['vendredis'] = $creneaux_vendredis;
        $args['samedis'] = $creneaux_samedis;
        $args['dimanches'] = $creneaux_dimanches;
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