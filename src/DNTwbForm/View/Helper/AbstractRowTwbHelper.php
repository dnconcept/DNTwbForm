<?php

namespace DNTwbForm\View\Helper;

use DNTwbForm\View\ViewHelperException;
use Zend\Form\ElementInterface;
use Zend\View\Helper\AbstractHelper;

/**
 * Description of AbstractRowTwbHelper
 *
 * @author Nicolas Desprez <contact@dnconcept.fr>
 */
abstract class AbstractRowTwbHelper extends AbstractHelper {

   private static $labelWidth = 3;
   private static $inputWidth = 9;
   private static $groupClass = "form-group";

   /** @var boolean    */
   private $hasLabel;

   /** @var ElementInterface    */
   private $element;
   private $messages = array();

   /**
    * @return boolean
    */
   protected function hasLabel() {
      return $this->hasLabel;
   }

   protected function setHasLabel($hasLabel) {
      $this->hasLabel = $hasLabel;
      return $this;
   }

   public static function setLabelWidth($labelWidth) {
      self::$labelWidth = $labelWidth;
   }

   public static function setInputWidth($inputWidth) {
      self::$inputWidth = $inputWidth;
   }

   protected function getLabelWidth() {
      return self::$labelWidth;
   }

   protected function getInputWidth() {
      return self::$inputWidth;
   }

   protected function getWidthClass($width) {
      return "col-sm-$width";
   }

   protected function getLabelColumnClass() {
      return $this->getWidthClass($this->getLabelWidth());
   }

   protected function getInputColumnClass() {
      return $this->getWidthClass($this->getInputWidth());
   }

   protected function getInputColumnWithOffsetClass() {
      return "col-sm-offset-{$this->getLabelWidth()} " . $this->getInputColumnClass();
   }

   protected function getTotalColumnClass() {
      $total = $this->getInputWidth() + $this->getLabelWidth();
      return $this->getWidthClass($total);
   }

   protected function getErrorsAsString() {
      $this->checkElement();
      $class = $this->hasLabel() ? $this->getInputColumnWithOffsetClass() : $this->getTotalColumnClass();
      $errors = "<div class='$class form-errors'>";
      $errors .= $this->getView()->formElementErrors($this->element);
      $errors .= '</div>';
      return $errors;
   }

   protected function setElement(ElementInterface $element) {
      $this->element = $element;
      $this->messages = $element->getMessages();
      $this->setHasLabel(!is_null($element->getLabel()));
      return $this;
   }

   private function checkElement() {
      if (!$this->element instanceof ElementInterface) {
         throw new ViewHelperException("An ElementInterface is required for the view helper");
      }
   }

   protected function renderGroup($value) {
      if (!is_string($value)) {
         throw new ViewHelperException("The value must be a valid string to render a group !");
      }
      if (count($this->messages) > 0) {
         return "<div class='" . self::$groupClass . " has-error'>{$value}{$this->getErrorsAsString()}</div>";
      }
      return "<div class='" . self::$groupClass . "'>$value</div>";
   }

}
