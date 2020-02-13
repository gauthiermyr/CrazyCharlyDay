<?php

namespace crazycharlyday\controllers;
use crazycharlyday\models\Creneau;
use crazycharlyday\models\Poste;
use Slim\Exception\NotFoundException;
use Slim\Http\Response;
use Slim\Http\Request;

class PlanningController extends Controller
{

    public function getCreneau(Request $request, Response $response, array $args){
        //$creneau = Creneau::where('id','=',$args['id'])->first();
        $postes = Poste::where('creneau','=',$args['id']);
        $args['postes'] = $postes;
        $this->container->view->render($response, 'contentCreneau.phtml', $args);
    }



}