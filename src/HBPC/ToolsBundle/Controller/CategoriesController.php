<?php

namespace HBPC\ToolsBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoriesController extends Controller{
    public function indexAction()
    {
        $cat = array(
            array(
            'id' => 1,
            'titre' => 'Catégorie Test'
            )
        );
        return $this->render('HBPCToolsBundle:Rubriques:categories.html.twig', array(
            'categories' => $cat
        ));
    }
}