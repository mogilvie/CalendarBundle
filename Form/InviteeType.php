<?php

namespace SpecShaper\CalendarBundle\Form;

//use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;

class InviteeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('organisation', TextType::class, array(
                    'required' => false,
                    'label' => 'specshaper_caledarbundle.label.organisation',
                ))
                ->add('userName', TextType::class, array(
                    'class' => 'AppBundle:Entity:User',
                    'required' => true,
                    'label' => 'specshaper_caledarbundle.label.chairPerson',
                ))
                ->add('emailAddress', EmailType::class, array(
                    'required' => false,
                    'label' => 'specshaper_caledarbundle.label.emailAddress',
                ))
        ;
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
        return 'appbundle_invitee';
    }
}
