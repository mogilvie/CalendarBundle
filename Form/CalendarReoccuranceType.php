<?php

namespace SpecShaper\CalendarBundle\Form;

//use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use SpecShaper\CalendarBundle\Model\CalendarReoccuranceInterface as Reoccurance;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

class CalendarReoccuranceType extends AbstractType {

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
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder
                ->add('period', ChoiceType::class, array(
                    'choices' => array(
                        'spec_shaper_calendar.choice.days' => Reoccurance::FREQUENCY_DAY,
                        'spec_shaper_calendar.choice.weeks' => Reoccurance::FREQUENCY_WEEK,
                        'spec_shaper_calendar.choice.months' => Reoccurance::FREQUENCY_MONTH,
                        'spec_shaper_calendar.choice.years' => Reoccurance::FREQUENCY_YEAR
                    ),
                    'required' => false,
                ))
                ->add('intervalBetween', IntegerType::class, array(
                    'label' => 'spec_shaper_calendarbundle.label.interval',
                    'attr' => array('min' => 1, 'max' => 30),
                    'required' => false,
                ))
                ->add('stopMethod', ChoiceType::class, array(
                    'choices' => array(
                        'spec_shaper_calendar.choice.iterations' => Reoccurance::END_ITERATIONS,
                        'spec_shaper_calendar.choice.endDate' => Reoccurance::END_DATE
                    ),
                    'label' => false,
                    'required' => false,
                ))
                ->addEventListener(
                        FormEvents::PRE_SET_DATA, function (FormEvent $event){
                    $this->selectInitialFormView($event);
                })
        ;

        $builder->get('period')->addEventListener(
                FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $this->periodChange($event);
        });

        $builder->get('stopMethod')->addEventListener(
                FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $this->stopMethodChange($event);
        });
    }

    private function selectInitialFormView(FormEvent $event) {
        
        $form = $event->getForm();
            // Get the data for this form (in this case it's the sub form's entity)
            // not the main form's entity
        $reoccurance = $event->getData();
        
        if(!$reoccurance){
            $this->setIterationStopMethod($form);
            return;
        }

        switch ($reoccurance->getPeriod()) {
            case Reoccurance::FREQUENCY_WEEK:
                $this->addDays($form);
                break;
        }        

        switch ($reoccurance->getStopMethod()) {
            case Reoccurance::END_DATE:
                $this->setEndDateStopMethod($form);
                break;
            default:
                $this->setIterationStopMethod($form);
                break;
        }
    }

    private function periodChange(FormEvent $event) {
        // It's important here to fetch $event->getForm()->getData(), as
        // $event->getData() will get you the client data (that is, the ID)
        $period = $event->getForm()->getData();

        switch ($period) {
            case Reoccurance::FREQUENCY_WEEK:
                $this->addDays($event->getForm()->getParent());
                break;
        }
    }

    public function addDays(FormInterface $form) {
        $form->add('days', ChoiceType::class, array(
            'choices' => array(
                'spec_shaper_calendar.choice.firstLetter.sunday' => Reoccurance::DAY_SUNDAY,
                'spec_shaper_calendar.choice.firstLetter.monday' => Reoccurance::DAY_MONDAY,
                'spec_shaper_calendar.choice.firstLetter.tuesday' => Reoccurance::DAY_TUESDAY,
                'spec_shaper_calendar.choice.firstLetter.wednesday' => Reoccurance::DAY_WEDNESDAY,
                'spec_shaper_calendar.choice.firstLetter.thursday' => Reoccurance::DAY_THURSDAY,
                'spec_shaper_calendar.choice.firstLetter.friday' => Reoccurance::DAY_FRIDAY,
                'spec_shaper_calendar.choice.firstLetter.saturday' => Reoccurance::DAY_SATURDAY,
            ),
            'expanded' => true,
            'multiple' => true,
            'required' => true,
            'label_attr' => array('class' => 'checkbox-inline'),
            'required' => false,
        ));
    }

    public function removeDays(FormInterface $form) {
        $form->remove('days');
    }

    private function stopMethodChange(FormEvent $event) {
        // It's important here to fetch $event->getForm()->getData(), as
        // $event->getData() will get you the client data (that is, the ID)
        $stopMethod = $event->getForm()->getData();

        switch ($stopMethod) {
            case Reoccurance::END_ITERATIONS:
                $this->setIterationStopMethod($event->getForm()->getParent());
                break;
            case Reoccurance::END_DATE:
                $this->setEndDateStopMethod($event->getForm()->getParent());
                break;
        }
    }

    private function setIterationStopMethod(FormInterface $form) {
        $form
                ->remove('endDate')
                ->add('iterations', IntegerType::class, array(
                    'label' => false,
                    'required' => false,
                    
                ))
        ;
    }

    private function setEndDateStopMethod(FormInterface $form) {

        $tomorrow = new \DateTime('now');
        $tomorrow->modify('+1 day');

        $form
                ->remove('iterations')
                ->add('endDate', null, array(
                    'widget' => 'single_text',
                    'format' => 'dd MMM yyyy',
                    'html5' => false,
                    'required' => false,
                    'label' => false,
                    'empty_data' => $tomorrow->format('d m Y')
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
    public function getBlockPrefix() {
        return 'spec_shaper_calendar_reoccurance';
    }

}
