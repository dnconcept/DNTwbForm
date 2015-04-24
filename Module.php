<?php

namespace DNTwbForm;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;

/**
 * Description of DNTwbFormModule
 * 
 * TwitterBootstrap Module for forms
 * 
 * This module provides basic view helpers for zf2 forms render with twitter bootstrap styles
 * 
 */
class Module implements AutoloaderProviderInterface, ConfigProviderInterface, ViewHelperProviderInterface {

   public function getConfig() {
      return include __DIR__ . '/config/module.config.php';
   }

   public function getAutoloaderConfig() {
      return array(
          'Zend\Loader\StandardAutoloader' => array(
              'namespaces' => array(
                  __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
              ),
          ),
      );
   }

   public function getViewHelperConfig() {
      return array(
          'invokables' => array(
              "formRowTwb" => __NAMESPACE__ . "\View\Helper\FormRowTwb",
              "formRowFileTwb" => __NAMESPACE__ . "\View\Helper\FormRowFileTwb",
              "formRowHtmlTwb" => __NAMESPACE__ . "\View\Helper\FormRowHtmlTwb",
              "formLabelTwb" => __NAMESPACE__ . "\View\Helper\FormLabelTwb",
              "formGroupTwb" => __NAMESPACE__ . "\View\Helper\FormGroupTwb",
              "formRowButtons" => __NAMESPACE__ . "\View\Helper\FormRowButtons",
          ),
          'factories' => array(
          ),
      );
   }

}
