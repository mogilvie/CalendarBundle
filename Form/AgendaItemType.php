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
use SpecShaper\CalendarBundle\Entity\PersistedEvent;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AgendaItemType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('topic', TextType::class, array(
                    'required' => true,
                    'label' => 'label.topic',
                ))
                ->add('text', TextareaType::class, array(
                    'required' => true,
                    'label' => 'label.text',
                ))
                ->add('duration', IntegerType::class, array(
                    'required' => false,
                    'label' => 'label.duration',
                ))
                ->add('partyResponsible', TextType::class, array(
                    'required' => false,
                    'label' => 'label.partyResponsible',
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
            'data_class' => 'SpecShaper\CalendarBundle\Entity\AgendaItem',
        ));
    }

    /**
     * Get the block prefix.
     *
     * @since  Available since Release 1.0.0
     *
     * @return string 'appbundle_agenda_item'
     */
    public function getBlockPrefix() {
        return 'appbundle_agenda_item';
    }

}
