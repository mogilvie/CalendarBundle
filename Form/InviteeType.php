<?php

namespace SpecShaper\CalendarBundle\Form;

//use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InviteeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('hasAccepted')
                ->add('emailAddress', EmailType::class, array(
                    'required' => false,
                    'label' => 'specshaper_caledarbundle.label.emailAddress',
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
            //'data_class' => 'SpecShaper\CalendarBundle\Model\InviteeInterface',
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
