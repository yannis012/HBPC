<?php

namespace HBPC\ToolsBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
// Import des entités :
use HBPC\ToolsBundle\Entity\Configuration;
//Gestion du Request
use Symfony\Component\HttpFoundation\Request;
//Formulaire
use HBPC\ToolsBundle\Form\ConfigAddCompType;
use HBPC\ToolsBundle\Form\ConfigurationType;

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
    
    public function addAction(Request $request) {
        $configuration = new Configuration();
        
        $form = $this->get('form.factory')->create(ConfigurationType::class, $configuration);
        
        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($configuration);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Configuration ajoutée.');
            return $this->redirectToRoute('hbpc_tools_gamme_view', array(
                'id' => $configuration->getGamme()->getId()
            ));
        }
        return $this->render('HBPCToolsBundle:Configuration:add.html.twig', array(
            'form' => $form->createView()
                ));
    }
     
    public function editAction($id, Request $request){
        $em = $this->getDoctrine()->getManager();
        $configuration = $em->getRepository('HBPCToolsBundle:Configuration')->find($id);
        
        if(null === $configuration){
            throw new NotFoundHttpException("Cette configuration n'existe pas");
        }
        
        $form = $this->get('form.factory')->create(ConfigurationType::class, $configuration);
        
        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $configuration->setMaj(0);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Configuration modifiée.');
            return $this->redirectToRoute('hbpc_tools_configuration_view', array('id' => $configuration->getId()));
        }
        return $this->render('HBPCToolsBundle:Configuration:edit.html.twig', array(
            'form' => $form->createView()
            ));
    }
    
    public function removeAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $configuration = $em->getRepository('HBPCToolsBundle:Configuration')->find($id);
        
        if (null === $configuration) {
            throw new NotFoundHttpException("La configuration d'id ".$id." n'existe pas.");
        }
        
        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $gamme = $configuration->getGamme();
            $em->remove($configuration);
            //On exécute tout ça
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Configuration supprimée.');
            return $this->redirectToRoute('hbpc_tools_gamme_view', array('id' => $gamme->getId()));
        }
        return $this->render('HBPCToolsBundle:Configuration:delete.html.twig', array(
            'config' => $configuration,
            'form'   => $form->createView(),
          ));
    }
    
    public function addCompAction($id, Request $request){
        $em = $this->getDoctrine()->getManager();
        
        $configuration = $em->getRepository('HBPCToolsBundle:Configuration')->find($id);
        
        if (null === $configuration) {
            throw new NotFoundHttpException("Cette config n'existe pas");
        }
        
        $form = $this->createForm(ConfigAddCompType::class, $configuration);
        
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $configuration->setMaj(0);
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
    
    public function majAction($id, Request $request){
        $em = $this->getDoctrine()->getManager();
        $configuration = $em->getRepository('HBPCToolsBundle:Configuration')->find($id);
        
        if(null === $configuration){
            throw new NotFoundHttpException("Cette configuration n'existe pas");
        }
        
        $configuration->setMaj(1);
        $em->flush();
        
        $request->getSession()->getFlashBag()->add('notice', 'Mise à jour validée');
        return $this->redirectToRoute('hbpc_tools_configuration_view', array('id' => $configuration->getId()));
    }
}