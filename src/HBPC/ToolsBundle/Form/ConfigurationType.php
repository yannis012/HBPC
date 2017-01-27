<?php

namespace HBPC\ToolsBundle\Form;

//Bride pour EntityType
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
//Form&co
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfigurationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('gamme', EntityType::class, array(
                    'class' => 'HBPCToolsBundle:Gamme',
                    'choice_label' => 'nom'
                ))
                ->add('nom',        TextType::class)
                ->add('reference',  TextType::class)
                ->add('prix',  MoneyType::class)     
                ->add('Enregistrer',       SubmitType::class)  
                ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HBPC\ToolsBundle\Entity\Configuration'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'hbpc_toolsbundle_configuration';
    }
}
