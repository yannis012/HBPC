<?php

namespace HBPC\ToolsBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ConfigController extends Controller{
    public function indexAction()
    {
        return $this->render('HBPCToolsBundle:Rubriques:config.html.twig');
    }
    
    public function viewAction()
    {
        return $this->render('HBPCToolsBundle:Pages:config_view.html.twig');
    }
}