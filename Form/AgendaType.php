<?php

namespace SpecShaper\CalendarBundle\Form;

//use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use SpecShaper\CalendarBundle\Entity\PersistedEvent;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AgendaType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('isTemplate', CheckboxType::class, array(
                    'required' => false,
                    'label' => 'label.isTemplate',
                ))
                ->add('chairPerson', TextType::class, array(
                    'required' => true,
                    'label' => 'label.chairPerson',
                ))
                ->add('location', TextType::class, array(
                    'required' => false,
                    'label' => 'label.location',
                ))
                ->add('duration', IntegerType::class, array(
                    'required' => false,
                    'label' => 'label.duration',
                ))
//                ->add('invitees', CollectionType::class, array(
//                    'required' => true,
//                    'label' => 'label.chairPerson',
//                ))
//                ->add('date', DateType::class, array(
//                    'required' => true,
//                    'label' => 'label.chairPerson',
//                ))
                ->add('agendaItem', CollectionType::class, array(
                    'entry_type'   => AgendaItemType::class,
                    'allow_add'    => true,
                    'allow_delete'    => true,
                ))
                
        ;
    }

    /**
     * Configure options.
     *
     * @since Available since Release 1.0.0
     *
     * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'SpecShaper\CalendarBundle\Entity\Agenda',
        ));
    }

    /**
     * Get the block prefix.
     *
     * @since  Available since Release 1.0.0
     *
     * @return string 'appbundle_agenda'
     */
    public function getBlockPrefix() {
        return 'appbundle_agenda';
    }

}
