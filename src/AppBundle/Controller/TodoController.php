<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends Controller
{
    /**
     * @Route("/list")
     */
    public function indexAction(Request $request)
    {
        $session = $request->getSession();
        if(! $session->has('mesTodos')) {
            $todos = array(
                'lundi' => 'Retour au travail',
                'Vendredi' => 'Web'
            );
            $session->set('mesTodos', $todos);
            $session->getFlashBag()->add('info', 'La liste des todos a été crée avec succées');
        }
        return $this->render('@App/Todo/index.html.twig');
    }

    /**
     * @Route("/todo/add/{title}/{content}",name="add-todo")
     */
    public function addAction(Request $request, $title, $content) {
        // s'il y a une session
        $session = $request->getSession();
        if (!$session->has('mesTodos')) {
            // si non
            // Erreur et redirection vers list
            $session->getFlashBag()->add('error', 'Session innexistante');
        } else {
            //si oui
            // si todo exist
            $mesTodos = $session->get('mesTodos');
            if(isset($mesTodos[$title])) {
                // si oui
                //message erreur +  redirection
                $session->getFlashBag()->add('error', "le todo ${title} existe déjà");
            } else {
                // sinon on l'ajoute et on redirige
                $mesTodos[$title] = $content;
                $session->set('mesTodos', $mesTodos);
                $session->getFlashBag()->add('success', "le todo ${title} a été ajouté avec succées");
            }
        }
        return $this->forward('AppBundle:Todo:index');
    }

}
