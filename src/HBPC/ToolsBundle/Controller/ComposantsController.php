<?php

namespace HBPC\ToolsBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ComposantsController extends Controller{
    public function indexAction()
    {
        
        return $this->render('HBPCToolsBundle:Rubriques:composants.html.twig');
    }
}