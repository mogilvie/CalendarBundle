<?php

namespace SpecShaper\CalendarBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Doctrine\Bundle\MongoDBBundle\DependencyInjection\Compiler\DoctrineMongoDBMappingsPass;
use Doctrine\Bundle\CouchDBBundle\DependencyInjection\Compiler\DoctrineCouchDBMappingsPass;
use Doctrine\Bundle\PHPCRBundle\DependencyInjection\Compiler\DoctrinePhpcrMappingsPass;

class SpecShaperCalendarBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        // ...

        $mappings = array(
            realpath(__DIR__.'/Resources/config/doctrine-mapping/model') => 'SpecShaper\CalendarBundle\Model',
        );

        $ormCompilerClass = 'Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass';

        if (class_exists($ormCompilerClass)) {
            $container->addCompilerPass(
                    DoctrineOrmMappingsPass::createXmlMappingDriver(
                            $mappings, array('spec_shaper_calender.model_manager_name'), 'spec_shaper_calendar.backend_type_orm',
                            array('SpecShaperCalendarBundle' => 'SpecShaper\CalendarBundle\Model')
            ));
        }

//        $mongoCompilerClass = 'Doctrine\Bundle\MongoDBBundle\DependencyInjection\Compiler\DoctrineMongoDBMappingsPass';
//        if (class_exists($mongoCompilerClass)) {
//            $container->addCompilerPass(
//                DoctrineMongoDBMappingsPass::createXmlMappingDriver(
//                    $mappings,
//                    array('spec_shaper_calendar.model_manager_name'),
//                    'spec_shaper_calendar.backend_type_mongodb',
//                    array('SpecShaperCalendarBundle' => 'Symfony\SpecShaper\CalendarBundle\Model')
//            ));
//        }
//
//        $couchCompilerClass = 'Doctrine\Bundle\CouchDBBundle\DependencyInjection\Compiler\DoctrineCouchDBMappingsPass';
//        if (class_exists($couchCompilerClass)) {
//            $container->addCompilerPass(
//                DoctrineCouchDBMappingsPass::createXmlMappingDriver(
//                    $mappings,
//                    array('spec_shaper_calendar.model_manager_name'),
//                    'spec_shaper_calendar.backend_type_couchdb',
//                    array('SpecShaperCalendarBundle' => 'Symfony\SpecShaper\CalendarBundle\Model')
//            ));
//        }
//
//        $phpcrCompilerClass = 'Doctrine\Bundle\PHPCRBundle\DependencyInjection\Compiler\DoctrinePhpcrMappingsPass';
//        if (class_exists($phpcrCompilerClass)) {
//            $container->addCompilerPass(
//                DoctrinePhpcrMappingsPass::createXmlMappingDriver(
//                    $mappings,
//                    array('spec_shaper_calendar.model_manager_name'),
//                    'spec_shaper_calendar.backend_type_phpcr',
//                    array('SpecShaperCalendarBundle' => 'Symfony\SpecShaper\CalendarBundle\Model')
//            ));
//        }
    }
}
