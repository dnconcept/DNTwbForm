<?php

namespace DNTwbForm\View\Helper;

use Zend\Form\ElementInterface;

/**
 * Description of FormRowTwb
 *
 * @author Nicolas Desprez <contact@dnconcept.fr>
 */
class FormRowTwb extends AbstractRowTwbHelper {

   public function __invoke(ElementInterface $element = null, $noLabel = false) {
      if (!$element) {
         return $this;
      }
      $view = $this->getView();
      if ($element instanceof \Zend\Form\Element\Hidden){
         return $view->formHidden($element);
      }
      $this->setElement($element);
      $this->setHasLabel(!is_null($element->getLabel()) && $noLabel === false);
      if ($element instanceof \Zend\Form\Element\Checkbox) {
         $labelCheck = sprintf("<label>%s %s</label>", $view->formCheckbox($element), $element->getLabel());
         $check = sprintf('<div class="%s checkbox">%s</div>', $this->getInputColumnWithOffsetClass(), $labelCheck);
         return $this->renderGroup($check);
      } elseif ($element instanceof \Zend\Form\Element\Select) {
         $elementRender = $view->formSelect($element);
      } else {
         $elementRender = $view->formElement($element);
      }
      $class = $this->hasLabel() ? $this->getInputColumnClass() : $this->getTotalColumnClass();
      $Input = sprintf('<div class="%s">%s</div>', $class, $elementRender);
      $label = ($this->hasLabel()) ? $view->formLabelTwb($element) : "";
      return $this->renderGroup("{$label}{$Input}");
   }

}
