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
use SpecShaper\CalendarBundle\Model\PersistedEventInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersistedEventType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('title', TextType::class, array(
                    'required' => true,
                    'label' => 'specshaper_caledarbundle.label.title',
                ))
                ->add('startDate', DateType::class, array(
                    'widget' => 'single_text',
                    'format' => 'dd MMM yyyy',
                    'html5' => false,
                    'required' => true,
                    'label' => 'specshaper_caledarbundle.label.startDate',
                    'label' => false,
                ))
                ->add('startTime', TimeType::class, array(
                    'widget' => 'single_text',
                    'required' => true,
                    'label' => 'specshaper_caledarbundle.label.startTime',
                    'label' => false,
                ))
                ->add('endDate', DateType::class, array(
                    'widget' => 'single_text',
                    'format' => 'dd MMM yyyy',
                    'html5' => false,
                    'required' => true,
                    'label' => 'specshaper_caledarbundle.label.endDate',
                    'label' => false,
                ))
                ->add('endTime', TimeType::class, array(
                    'widget' => 'single_text',
                    'required' => true,
                    'label' => 'specshaper_caledarbundle.label.endTime',
                    'label' => false,
                ))
                ->add('isAllDay', CheckboxType::class, array(
                    'required' => false,
                    'label' => 'specshaper_caledarbundle.label.isAllDay',
                ))
                ->add('isReoccuring', CheckboxType::class, array(
                    'required' => false,
                    'label' => 'specshaper_caledarbundle.label.isReoccuring',
                ))
                ->add('period', ChoiceType::class, array(
                    'choices' => array(
                        'specshaper_caledarbundle.choice.daily' => PersistedEventInterface::REPEAT_DAILY,
                        'specshaper_caledarbundle.choice.weekly' => PersistedEventInterface::REPEAT_WEEKLY,
                        'specshaper_caledarbundle.choice.fortnightly' => PersistedEventInterface::REPEAT_FORTNIGHTLY,
                        'specshaper_caledarbundle.choice.monthly' => PersistedEventInterface::REPEAT_MONTHLY,
                    ),
                    'required' => true,
                    'label' => 'specshaper_caledarbundle.label.period',
                ))
                ->add('repeatUntil', TextType::class, array(
                    'required' => false,
                    'mapped' => false,
                    'label' => 'specshaper_caledarbundle.label.repeatUntil',
                ))
                ->add('text', TextareaType::class, array(
                    'attr' => array('rows' => 9),
                    'required' => true,
                    'label' => 'specshaper_caledarbundle.label.text',
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
            'data_class' => 'SpecShaper\CalendarBundle\Model\PersistedEventInterface',
        ));
    }

    /**
     * Get the block prefix.
     *
     * @since  Available since Release 1.0.0
     *
     * @return string 'appbundle_persisted_event'
     */
    public function getBlockPrefix()
    {
        return 'specshaper_calendar_persisted_event';
    }
}
