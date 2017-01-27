<?php

namespace HBPC\ToolsBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// Import des entités :
use HBPC\ToolsBundle\Entity\Categorie;
//Gestion du Request
use Symfony\Component\HttpFoundation\Request;
//Formulaire & co
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CategorieController extends Controller{
    public function indexAction()
    {
        $categories = $this->getCategories();
        return $this->render('HBPCToolsBundle:Categorie:index.html.twig', array(
            'categories' => $categories));
    }
    
    public function addAction(Request $request) {
        $categorie = new Categorie();
        $form = $this->get('form.factory')->createBuilder(FormType::class, $categorie)
                ->add('nom',        TextType::class)
                ->add('Enregistrer',       SubmitType::class)
                ->getForm()
            ;
        if ($request->isMethod('POST')) {
            if($form->handleRequest($request)->isValid()){
                if($categorie->getPosition() == null){
                    $categorie->setPosition(0);
                }
                $em = $this->getDoctrine()->getManager();
                $em->persist($categorie);
                $em->flush();
                $request->getSession()->getFlashBag()->add('notice', 'Catégorie enregistré.');
                return $this->redirectToRoute('hbpc_tools_categories');
            }
        }
        return $this->render('HBPCToolsBundle:Categorie:add.html.twig', array(
            'form' => $form->createView()
                ));
    }
     
    public function editAction($id, Request $request){
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository('HBPCToolsBundle:Categorie')->find($id);
        
        if(null === $categorie){
            throw new NotFoundHttpException("Cette catégorie n'existe pas");
        }
        
        $form = $this->get('form.factory')->createBuilder(FormType::class, $categorie)
                ->add('nom',        TextType::class)
                ->add('Enregistrer',       SubmitType::class)
                ->getForm()
            ;
        
        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Catégorie modifiée.');
            return $this->redirectToRoute('hbpc_tools_categorie_view', array('id' => $categorie->getId()));
        }
        return $this->render('HBPCToolsBundle:Categorie:edit.html.twig', array(
            'form' => $form->createView()
            ));
    }  
    
    public function removeAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository('HBPCToolsBundle:Categorie')->find($id);
        
        if (null === $categorie) {
            throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }
        
        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            //Suppresion des composants de la catégorie
            $composants=$this->getComposants($id);
            foreach($composants as $composant){
                $em->remove($composant);
            }
            $em->remove($categorie);
            //On exécute tout ça
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Catégorie supprimée.');
            return $this->redirectToRoute('hbpc_tools_categories');
        }
        return $this->render('HBPCToolsBundle:Categorie:delete.html.twig', array(
            'cat' => $categorie,
            'form'   => $form->createView(),
          ));
    }
    public function viewAction($id) {
        $categorie = $this->getCategorie($id);
        $composants= $this->getComposants($id);
        return $this->render('HBPCToolsBundle:Categorie:view.html.twig', array(
            'categorie' =>$categorie,
            'composants'=>$composants
        ));
    }
    
    public function getCategories(){
        $repository=$this->getDoctrine()
                         ->getManager()
                         ->getRepository('HBPCToolsBundle:Categorie')
                ;
        $categories = $repository->findAllSortASC();
        return $categories;
    }
    
    public function getCategorie($id){
        $repository=$this->getDoctrine()
                         ->getManager()
                         ->getRepository('HBPCToolsBundle:Categorie')
                    ;
        
        return $categorie = $repository->findOneBy(array('id' => $id));  
    }
    
    public function getComposants($categorie){
        $repository=$this->getDoctrine()
                         ->getManager()
                         ->getRepository('HBPCToolsBundle:Composant')
                    ;
        
        return $composants = $repository->findBy(array('categorie' => $categorie));
    }
    
}