<?php

namespace HBPC\ToolsBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
// Import des entités :
use HBPC\ToolsBundle\Entity\Composant;
//Gestion du Request
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
//Formulaire
use HBPC\ToolsBundle\Form\ComposantType;

class ComposantController extends Controller{
    
    public function indexAction()
    {
        $composants = $this->getComposants();
        return $this->render('HBPCToolsBundle:Composant:index.html.twig', array(
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
    
    public function addAction(Request $request){
        $composant = new Composant();
        
        $form = $this->get('form.factory')->create(ComposantType::class, $composant);
        
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if($form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $em->persist($composant);
                $em->flush();
                $request->getSession()->getFlashBag()->add('notice', 'Composant enregistré.');
                return $this->redirectToRoute('hbpc_tools_categorie_view', array('id' => $composant->getCategorie()->getId()));
            }
        }
        return $this->render('HBPCToolsBundle:Composant:add.html.twig', array(
            'form' => $form->createView()
            ));
    }
    
    public function editAction($id, Request $request){
        $em = $this->getDoctrine()->getManager();
        $composant = $em->getRepository('HBPCToolsBundle:Composant')->find($id);
        if(null === $composant){
            throw new NotFoundHttpException("Ce composant n'existe pas");
        }
        
        $form = $this->get('form.factory')->create(ComposantType::class, $composant);
        
        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Composant modifié.');
            return $this->redirectToRoute('hbpc_tools_categorie_view', array('id' => $composant->getCategorie()->getId()));
        }
        return $this->render('HBPCToolsBundle:Composant:edit.html.twig', array(
            'form' => $form->createView(),
            'id_cat' => $composant->getCategorie()->getId()
            ));
    }   
    
    public function removeAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $composant = $em->getRepository('HBPCToolsBundle:Composant')->find($id);
        
        if (null === $composant) {
            throw new NotFoundHttpException("Le composant d'id ".$id." n'existe pas.");
        }
        
        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $categorie = $composant->getCategorie();
            $em->remove($composant);
            //On exécute tout ça
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Composant supprimé.');
            return $this->redirectToRoute('hbpc_tools_categorie_view', array('id' => $categorie->getId()));
        }
        return $this->render('HBPCToolsBundle:Composant:delete.html.twig', array(
            'comp' => $composant,
            'form'   => $form->createView(),
          ));
    }
    
    public function reduireStockAction($id, $config, Request $request){
        $em = $this->getDoctrine()->getManager();
        $composant = $em->getRepository('HBPCToolsBundle:Composant')->find($id);
        
        if(null === $composant){
            throw new NotFoundHttpException("Ce composant n'existe pas");
        }
        $stock = $composant->getStock() - 1;
        $composant->setStock($stock);
        $em->flush();
        
        $request->getSession()->getFlashBag()->add('notice', 'Stock réduit');
        return $this->redirectToRoute('hbpc_tools_configuration_view', array('id' => $config));
    }
}