<?php

namespace HBPC\ToolsBundle\Form;

//Bride pour EntityType
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
//Form&co
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComposantType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('categorie', EntityType::class, array(
                    'class' => 'HBPCToolsBundle:Categorie',
                    'choice_label' => 'nom'
                ))
                ->add('nom',        TextType::class)
                ->add('reference',  TextType::class)
                ->add('prixVente',  MoneyType::class)
                ->add('prixAchat',  MoneyType::class)
                ->add('fournisseur',  TextType::class)
                ->add('fournisseurRef',  TextType::class)
                ->add('stock',  IntegerType::class)
                ->add('Enregistrer',       SubmitType::class)      
                ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HBPC\ToolsBundle\Entity\Composant'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'hbpc_toolsbundle_composant';
    }
}
