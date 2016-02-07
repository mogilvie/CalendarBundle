<?php

namespace SpecShaper\CalendarBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use SpecShaper\CalendarBundle\Form\CalendarReoccuranceType;
use SpecShaper\CalendarBundle\Form\CalendarAttendeeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class CalendarEventType extends AbstractType {

    private $manager;

    public function __construct(ObjectManager $manager) {
        $this->manager = $manager;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $event = $builder->getData();

        $builder
                ->add('bgColor', ChoiceType::class, array(
                    'choices' => array(
                        'Green' => '#7bd148',
                        'Bold blue' => '#5484ed',
                        'Blue' => '#a4bdfc',
                        'Turquoise' => '#46d6db',
                        'Light green' => '#7ae7bf',
                        'Bold green' => '#51b749',
                        'Yellow' => '#fbd75b',
                        'Orange' => '#ffb878',
                        'Red' => '#ff887c',
                        'Bold red' => '#dc2127',
                        'Purple' => '#dbadff',
                        'Gray' => '#e1e1e1',
                    ),
                    'mapped' => true,
                    'required' => true,
                    'label' => false,
                ))
                ->add('location', TextType::class, array(
                    'required' => false,
                    'attr' => array('autocomplete' => true),
                    'label' => 'spec_shaper_calendarbundle.label.location',
                ))
                ->add('title', TextType::class, array(
                    'required' => true,
                    'label' => 'spec_shaper_calendarbundle.label.title',
                ))
                ->add('isAllDay', CheckboxType::class, array(
                    'required' => false,
                    'label' => 'spec_shaper_calendarbundle.label.isAllDay',
                ))
                ->add('isReoccuring', CheckboxType::class, array(
                    'required' => false,
                    'label' => 'spec_shaper_calendarbundle.label.isReoccuring',
                ))
                ->add('text', TextareaType::class, array(
                    'attr' => array('rows' => 12),
                    'required' => true,
                    'label' => 'spec_shaper_calendarbundle.label.text',
                ))
                ->add('calendarAttendees', CollectionType::class, array(
                    'entry_type' => CalendarAttendeeType::class,
                    'by_reference' => false,
                    'allow_add' => true,
                    'allow_delete' => true,
                ))
                ->add('updateAttendees', CheckboxType::class, array(
                    'mapped' => false,
                    'required' => false,
                    'attr' => array('class' => 'hidden'),
                ))
                ->addEventListener(
                        FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                    $this->selectInitialFormView($event);
                })

        ;
    }

    private function selectInitialFormView(FormEvent $formEvent) {

        $form = $formEvent->getForm();

        $event = $formEvent->getData();

        $form
                ->add('startDate', DateType::class, array(
                    'widget' => 'single_text',
                    'format' => 'dd MMM yyyy',
                    'html5' => false,
                    'required' => true,
                    'label' => 'spec_shaper_calendarbundle.label.startDate',
                    'label' => false,
                    'mapped' => false,
                    'data' => $event->getStartDatetime()
                ))
                ->add('startTime', TimeType::class, array(
                    'widget' => 'single_text',
                    'required' => true,
                    'label' => 'spec_shaper_calendarbundle.label.startTime',
                    'label' => false,
                    'mapped' => false,
                    'data' => $event->getStartDatetime()
                ))
                ->add('endDate', DateType::class, array(
                    'widget' => 'single_text',
                    'format' => 'dd MMM yyyy',
                    'html5' => false,
                    'required' => true,
                    'label' => 'spec_shaper_calendarbundle.label.endDate',
                    'label' => false,
                    'mapped' => false,
                    'data' => $event->getEndDatetime()
                ))
                ->add('endTime', TimeType::class, array(
                    'widget' => 'single_text',
                    'required' => true,
                    'label' => 'spec_shaper_calendarbundle.label.endTime',
                    'label' => false,
                    'mapped' => false,
                    'data' => $event->getEndDatetime()
                ))
                ->add('calendarReoccurance', CalendarReoccuranceType::class, array(
                    'error_bubbling' => false
           //         'disabled' => !$event->getIsReoccuring()
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
            'data_class' => 'SpecShaper\CalendarBundle\Model\CalendarEventInterface',
            'cascade_validation' => true,
        ));
    }

    /**
     * Get the block prefix.
     *
     * @since  Available since Release 1.0.0
     *
     * @return string 'appbundle_calendar_event'
     */
    public function getBlockPrefix() {
        return 'spec_shaper_calendar_event';
    }

}
