<?php

namespace SpecShaper\CalendarBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class SpecShaperCalendarExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        if ('custom' !== $config['db_driver']) {
            $loader->load(sprintf('%s.xml', $config['db_driver']));
            $container->setParameter($this->getAlias().'.backend_type_'.$config['db_driver'], true);
        }

        if ('custom' !== $config['db_driver'] && 'propel' !== $config['db_driver']) {
            if ('orm' === $config['db_driver']) {
                $managerService = 'spec_shaper_calender.entity_manager';
                $doctrineService = 'doctrine';
            } else {
                $managerService = 'spec_shaper_calendar.document_manager';
                $doctrineService = sprintf('doctrine_%s', $config['db_driver']);
            }

            $definition = $container->getDefinition($managerService);

            if (method_exists($definition, 'setFactory')) {
                $definition->setFactory(array(new Reference($doctrineService), 'getManager'));
            } else {
                $definition->setFactoryService($doctrineService);
                $definition->setFactoryMethod('getManager');
            }
        }

        foreach ($config['custom_classes'] as $customClassKey => $customClassName) {
            $parameterName = $this->getAlias().'.'.$customClassKey;
            $container->setParameter($parameterName, $customClassName);
        }

//
////        foreach (array('validator', 'security', 'util', 'mailer', 'listeners') as $basename) {
////            $loader->load(sprintf('%s.xml', $basename));
////        }
////
////        // Set the SecurityContext for Symfony <2.6
////        // Should go back to simple xml configuration after <2.6 support
////        if (interface_exists('Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface')) {
////            $tokenStorageReference = new Reference('security.token_storage');
////        } else {
////            $tokenStorageReference = new Reference('security.context');
////        }
////        $container
////            ->getDefinition('fos_user.security.login_manager')
////            ->replaceArgument(0, $tokenStorageReference)
////        ;
//
////        if ($config['use_flash_notifications']) {
////            $loader->load('flash_notifications.xml');
////        }
////
////        $container->setAlias('fos_user.mailer', $config['service']['mailer']);
////        $container->setAlias('fos_user.util.email_canonicalizer', $config['service']['email_canonicalizer']);
////        $container->setAlias('fos_user.util.username_canonicalizer', $config['service']['username_canonicalizer']);
////        $container->setAlias('fos_user.util.token_generator', $config['service']['token_generator']);
////        $container->setAlias('fos_user.user_manager', $config['service']['user_manager']);
//
////        if ($config['use_listener']) {
////            switch ($config['db_driver']) {
////                case 'orm':
////                    $container->getDefinition('fos_user.user_listener')->addTag('doctrine.event_subscriber');
////                    break;
////
////                case 'mongodb':
////                    $container->getDefinition('fos_user.user_listener')->addTag('doctrine_mongodb.odm.event_subscriber');
////                    break;
////
////                case 'couchdb':
////                    $container->getDefinition('fos_user.user_listener')->addTag('doctrine_couchdb.event_subscriber');
////                    break;
////
////                case 'propel':
////                    break;
////
////                default:
////                    break;
////            }
////        }
////        if ($config['use_username_form_type']) {
////            $loader->load('username_form_type.xml');
////        }
//
//        $this->remapParametersNamespaces($config, $container, array(
//            ''          => array(
//                'db_driver' => 'fos_user.storage',
////               'firewall_name' => 'fos_user.firewall_name',
//                'model_manager_name' => 'fos_user.model_manager_name',
////                'user_class' => 'fos_user.model.user.class',
//            ),
//        ));
//
////        if (!empty($config['profile'])) {
////            $this->loadProfile($config['profile'], $container, $loader);
////        }
////
////        if (!empty($config['registration'])) {
////            $this->loadRegistration($config['registration'], $container, $loader, $config['from_email']);
////        }
////
////        if (!empty($config['change_password'])) {
////            $this->loadChangePassword($config['change_password'], $container, $loader);
////        }
////
////        if (!empty($config['resetting'])) {
////            $this->loadResetting($config['resetting'], $container, $loader, $config['from_email']);
////        }
////
////        if (!empty($config['group'])) {
////            $this->loadGroups($config['group'], $container, $loader, $config['db_driver']);
////        }
//        
//        
//    }
//    
//    protected function remapParameters(array $config, ContainerBuilder $container, array $map)
//    {
//        foreach ($map as $name => $paramName) {
//            if (array_key_exists($name, $config)) {
//                $container->setParameter($paramName, $config[$name]);
//            }
//        }
//    }
//    
//    protected function remapParametersNamespaces(array $config, ContainerBuilder $container, array $namespaces)
//    {
//        foreach ($namespaces as $ns => $map) {
//            if ($ns) {
//                if (!array_key_exists($ns, $config)) {
//                    continue;
//                }
//                $namespaceConfig = $config[$ns];
//            } else {
//                $namespaceConfig = $config;
//            }
//            if (is_array($map)) {
//                $this->remapParameters($namespaceConfig, $container, $map);
//            } else {
//                foreach ($namespaceConfig as $name => $value) {
//                    $container->setParameter(sprintf($map, $name), $value);
//                }
//            }
//        }
//    }
////    
////    public function getNamespace()
////    {
////        return 'http://specshaper.com/schema/dic/calendar';
////    }
////    
////    public function getXsdValidationBasePath()
////    {
////        return __DIR__.'/../Resources/config/schema';
    }
}
