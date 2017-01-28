<?php

namespace HBPC\ToolsBundle\Form;

//Bride pour EntityType
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
//Form&co
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ConfigAddCompType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('composants', EntityType::class, array(
                    'class' => 'HBPCToolsBundle:Composant',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('c')
                            ->orderBy('c.categorie', 'ASC')
                            ->addOrderBy('c.nom', 'ASC');
                    },
                    'choice_label' => 'nom',
                    'group_by' => 'categorie.nom',
                    'multiple' => true
                ))
                ->add('Ajouter', SubmitType::class)
                ;
    }
    
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
