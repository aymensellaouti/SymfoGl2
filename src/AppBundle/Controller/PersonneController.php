<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Personne;
use AppBundle\Form\PersonneType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PersonneController
 * @package AppBundle\Controller
 * @Route("/personne")
 */
class PersonneController extends Controller
{
    /**
     * @Route("/list")
     */
    public function listAction()
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Personne');
        $personnes = $repository->findAll();
        return $this->render('@App/Personne/list.html.twig', array(
            'personnes' => $personnes
        ));
    }

    /**
     * @param $id
     * @Route("/{id}", name="find.personne.id",
     *      requirements={"id": "\d+"})
     */
    public function findPersonneByIdAction(Personne $personne = null) {
        if (!$personne) {
            $personnes = array();
        } else {
            $personnes = array($personne);
        }
        return $this->render('@App/Personne/list.html.twig', array(
            'personnes' => $personnes
        ));
    }

    /**
     * @param $name
     * @param $firstname
     * @param $job
     * @param $age
     * @Route("/add/{name}/{firstname}/{job}/{age}", name="add.personne")
     */
    public function addPersonneAction($name, $firstname, $job, $age) {
        $personne = new Personne($name, $firstname, $job, $age);
        $em = $this->getDoctrine()->getManager();
        $em->persist($personne);
        $em->flush();
        return $this->forward('AppBundle:Personne:list');
    }

    /**
     * @param $name
     * @param $firstname
     * @param $job
     * @param $age
     * @Route("/update/{id}/{name}/{firstname}/{job}/{age}", name="add.personne")
     */
    public function updatePersonneAction(Personne $personne = null, $name, $firstname, $job, $age) {
        if($personne) {
            $em = $this->getDoctrine()->getManager();
            $personne->setName($name);
            $personne->setFirstname($firstname);
            $personne->setAge($age);
            $personne->setJob($job);
            $em->flush();
        }
        return $this->forward('AppBundle:Personne:list');
    }

    /**
     * @param Personne|null $personne
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/remove/{id}", name="personne.remove")
     */
    public function removePersonneAction(Personne $personne = null) {
        if($personne) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($personne);
            $em->flush();
        }
        return $this->forward('AppBundle:Personne:list');
    }

    /**
     * @Route("/addf/{id}", name="add.form.personne", defaults={"id": 0})
     */
    public function addFormPersonneAction(Request $request, Personne $personne=null) {
        if(!$personne)
            $personne = new Personne();
        $form = $this->createForm(PersonneType::class, $personne);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($personne);
            $em->flush();
            return $this->forward('AppBundle:Personne:list');
        }
        return $this->render('@App/personne/add.html.twig', array(
            'form' => $form->createView()
        ));
    }

}
