<?php

namespace HBPC\ToolsBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ConfigController extends Controller{
    public function indexAction()
    {
        $repository=$this->getDoctrine()
                         ->getManager()
                         ->getRepository('HBPCToolsBundle:Configuration')
                ;
        $configurations = $repository->findAll();
        return $this->render('HBPCToolsBundle:Rubriques:config.html.twig', array(
            'configurations' => $configurations,
        ));
    }
    
    public function viewAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $configuration= $em->getRepository('HBPCToolsBundle:Configuration')->findOneById($id);
        $composants = $configuration->getComposants();
        return $this->render('HBPCToolsBundle:Pages:config_view.html.twig', array('configuration' => $configuration, 'composants' => $composants));
    }
}