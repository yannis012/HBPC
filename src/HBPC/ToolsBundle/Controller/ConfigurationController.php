<?php

namespace HBPC\ToolsBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
// Import des entités :
use HBPC\ToolsBundle\Entity\Configuration;
//Gestion du Request
use Symfony\Component\HttpFoundation\Request;
//Formulaire
use HBPC\ToolsBundle\Form\ConfigAddCompType;

class ConfigurationController extends Controller{
    public function viewGammeAction($id)
    {
        $em=$this->getDoctrine()
                 ->getManager()
                ;
        $configurations = $em->getRepository('HBPCToolsBundle:Configuration')->findByGamme($id, array('prix' => 'ASC'));
        $categorie = $em->getRepository('HBPCToolsBundle:Gamme')->findOneById($id);
        return $this->render('HBPCToolsBundle:Gamme:view_configuration.html.twig', array(
            'categorie' => $categorie,
            'configurations' => $configurations,
        ));
    }
    
    public function viewConfAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $infos = $em->getRepository('HBPCToolsBundle:Configuration')->findAllByConfigCustom($id);
        //$composants = $configuration->getComposants();
        if($infos == null){
            $configuration = $em->getRepository('HBPCToolsBundle:Configuration')->findOneById($id);
        }else{
            $configuration = $infos[0];
        }
        return $this->render('HBPCToolsBundle:Configuration:view.html.twig', array('configuration' => $configuration));
    }
    
    public function addCompAction($id, Request $request){
        $em = $this->getDoctrine()->getManager();
        
        $configuration = $em->getRepository('HBPCToolsBundle:Configuration')->find($id);
        
        if (null === $configuration) {
            throw new NotFoundHttpException("Cette config n'existe pas");
        }
        
        $form = $this->createForm(ConfigAddCompType::class, $configuration);
        
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->persist($configuration);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Composant ajouté');
            return $this->redirectToRoute('hbpc_tools_configuration_view', array('id' => $configuration->getId()));
        }
        return $this->render('HBPCToolsBundle:Configuration:config_add_comp.html.twig', array(
            'form' => $form->createView(),
            'configuration' => $configuration
            ));
    }
}