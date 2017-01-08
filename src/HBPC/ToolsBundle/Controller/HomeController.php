<?php

namespace HBPC\ToolsBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller{
    public function indexAction()
    {
        return $this->render('HBPCToolsBundle:Default:index.html.twig');
    }
}
