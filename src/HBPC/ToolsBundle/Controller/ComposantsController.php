<?php

namespace HBPC\ToolsBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ComposantsController extends Controller{
    public function indexAction()
    {
        $composants = $this->getComposants();
        return $this->render('HBPCToolsBundle:Rubriques:composants.html.twig', array(
            'composants' => $composants));
    }
    
    public function getComposants(){
        $repository=$this->getDoctrine()
                         ->getManager()
                         ->getRepository('HBPCToolsBundle:Composant')
                ;
        $composants = $repository->findAllSortCat();
        return $composants;
    }
}