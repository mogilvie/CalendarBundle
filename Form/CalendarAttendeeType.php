<?php

namespace SpecShaper\CalendarBundle\Form;

//use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalendarAttendeeType extends AbstractType
{
    /**
     * The class name of the entity as defined in the config.
     * 
     * @var string $entityClass
     */
    private $entityClass;

    /**
     * Constructor to get the class name passed from the service xml.
     * 
     * @param string $entityClass
     */
    public function __construct($entityClass) {
        $this->entityClass = $entityClass;
    }
    
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('isOptional', CheckboxType::class, array(
                    'required' => false,
                    'label' => false,
                ))
                ->add('emailAddress', HiddenType::class, array(
                    'required' => true,
                    'label' => false,
                    'attr' => array('class' => 'hiddenEmailAddress')
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
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->entityClass,
        ));
    }

    /**
     * Get the block prefix.
     *
     * @since  Available since Release 1.0.0
     *
     * @return string 'appbundle_attendee'
     */
    public function getBlockPrefix()
    {
        return 'spec_shaper_calendar_attendee';
    }
}
