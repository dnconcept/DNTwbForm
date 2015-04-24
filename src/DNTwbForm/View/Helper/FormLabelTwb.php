<?php

namespace DNTwbForm\View\Helper;

use Zend\Form\LabelAwareInterface;

/**
 * Description of FormLabelTwb
 *
 * @author Nicolas Desprez <contact@dnconcept.fr>
 */
class FormLabelTwb extends AbstractRowTwbHelper {

   public function __invoke(LabelAwareInterface $element = null) {
      if (!$element) {
         return $this;
      }
      $view = $this->getView();
      $attributes = $element->getLabelAttributes();
      $twbClass = "control-label " . $this->getLabelColumnClass();
      $class = ((isset($attributes["class"])) ? $attributes["class"] . " " : "") . $twbClass;
      $element->setLabelAttributes(array_merge($attributes, array("class" => $class)));
      
      return $view->formLabel($element);
   }

}
