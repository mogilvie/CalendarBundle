<?php

namespace SpecShaper\CalendarBundle\Form;

//use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalendarInviteeType extends AbstractType
{
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
            //'data_class' => 'SpecShaper\CalendarBundle\Model\CalendarInviteeInterface',
            'data_class' => 'AppBundle\Entity\CalendarInvitee',
        ));
    }

    /**
     * Get the block prefix.
     *
     * @since  Available since Release 1.0.0
     *
     * @return string 'appbundle_invitee'
     */
    public function getBlockPrefix()
    {
        return 'specshaper_calendar_invitee';
    }
}
