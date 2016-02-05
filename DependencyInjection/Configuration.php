<?php

namespace SpecShaper\CalendarBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        
        $rootNode = $treeBuilder->root('spec_shaper_calendar', 'array');       

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        $supportedDrivers = array('orm'); //, 'mongodb', 'couchdb', 'propel', 'custom');

        $rootNode
            ->children()
                ->scalarNode('db_driver')
                    ->validate()
                        ->ifNotInArray($supportedDrivers)
                        ->thenInvalid('The driver %s is not supported. Please choose one of '.json_encode($supportedDrivers))
                    ->end()
                    ->cannotBeOverwritten()
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('model_manager_name')->end()
                ->arrayNode('custom_classes')
                    ->children()
                        ->scalarNode('attendee_class')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('calendar_class')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('event_class')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('comment_class')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('reoccurance_class')->isRequired()->cannotBeEmpty()->end()
                    ->end()
                ->end()
                ->scalarNode('voter')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
