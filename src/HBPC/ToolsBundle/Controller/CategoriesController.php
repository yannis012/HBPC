<?php

namespace HBPC\ToolsBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

// Import des entités :
use HBPC\ToolsBundle\Entity\Categorie;

class CategoriesController extends Controller{
    public function indexAction()
    {
        $categories = $this->getCategories();
        return $this->render('HBPCToolsBundle:Rubriques:categories.html.twig', array(
            'categories' => $categories));
    }
    
    public function addAction(Request $request) {
        
        if ($request->isMethod('POST')) {
            $categorie = new Categorie();
            $categorie->setNom("Test BDD")->setPosition(0);
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Catégorie enregistrée.');
            return $this->redirectToRoute('hbpc_tools_categories');
        }
        return $this->render('HBPCToolsBundle:Pages:categories_add.html.twig');
    }
    
    public function removeAction(Request $request, $id){
        //Récupération du manager
        $em = $this->getDoctrine()->getManager();
        //Récupération de la catégorie en qestion
        $categorie = $em->getRepository('HBPCToolsBundle:Categorie')->find($id);
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
    public function viewAction($id) {
        $categorie = $this->getCategorie($id);
        $composants= $this->getComposants($id);
        return $this->render('HBPCToolsBundle:Pages:categories_view.html.twig', array(
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