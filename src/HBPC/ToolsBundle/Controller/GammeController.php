<?php

namespace HBPC\ToolsBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// Import des entités :
use HBPC\ToolsBundle\Entity\Gamme;
//Gestion du Request
use Symfony\Component\HttpFoundation\Request;
//Formulaire & co
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
class GammeController extends Controller{
    public function indexAction()
    {
        $repository=$this->getDoctrine()
                         ->getManager()
                         ->getRepository('HBPCToolsBundle:Gamme')
                ;
        $categories = $repository->findAll();
        return $this->render('HBPCToolsBundle:Gamme:index.html.twig', array(
            'categories' => $categories,
        ));
    }
    
    public function addAction(Request $request) {
        $gamme = new Gamme();
        $form = $this->get('form.factory')->createBuilder(FormType::class, $gamme)
                ->add('nom',        TextType::class)
                ->add('Enregistrer',       SubmitType::class)
                ->getForm()
            ;
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($gamme);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Gamme enregistré.');
            return $this->redirectToRoute('hbpc_tools_gamme');
        }
        return $this->render('HBPCToolsBundle:Gamme:add.html.twig', array(
            'form' => $form->createView()
                ));
    }
    
    public function editAction($id, Request $request){
        $em = $this->getDoctrine()->getManager();
        $gamme = $em->getRepository('HBPCToolsBundle:Gamme')->find($id);
        
        if(null === $gamme){
            throw new NotFoundHttpException("Cette gamme n'existe pas");
        }
        
        $form = $this->get('form.factory')->createBuilder(FormType::class, $gamme)
                ->add('nom',        TextType::class)
                ->add('Enregistrer',       SubmitType::class)
                ->getForm()
            ;
        
        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Gamme modifiée.');
            return $this->redirectToRoute('hbpc_tools_gamme_view', array('id' => $gamme->getId()));
        }
        return $this->render('HBPCToolsBundle:Gamme:edit.html.twig', array(
            'form' => $form->createView()
            ));
    }  
}
