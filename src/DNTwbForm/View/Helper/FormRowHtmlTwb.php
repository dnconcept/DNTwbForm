<?php

namespace DNTwbForm\View\Helper;

use Zend\Form\ElementInterface;

/**
 * Description of FormRowHtmlTwb
 *
 * @author Nicolas Desprez <contact@dnconcept.fr>
 */
class FormRowHtmlTwb extends AbstractRowTwbHelper {

   public function __construct() {
      $this->myHtmlHelper = "html_entity_decode";
   }

   public function __invoke(ElementInterface $element = null, $noLabel = false) {
      if (!$element) {
         return $this;
      }
      $view = $this->getView();
      $this->setElement($element);
      if ($noLabel) {
         $this->setHasLabel($noLabel);
      }
      $tplInput = '<div class="%s">%s</div>';
      $escape = $this->myHtmlHelper;
      $InputHtml = sprintf(
              '<textarea %s>%s</textarea>', $view->formTextarea()->createAttributesString($element->getAttributes()), $escape($element->getValue())
      );
      $hasLabel = $this->hasLabel();
      $Input = sprintf($tplInput, $hasLabel ? $this->getInputColumnClass() : $this->getTotalColumnClass(), $InputHtml);
      $label = ($hasLabel) ? $view->formLabelTwb($element) : "";
      return $this->renderGroup("{$label}{$Input}");
   }

}
