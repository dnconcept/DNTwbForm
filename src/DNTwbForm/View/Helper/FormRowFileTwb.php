<?php

namespace DNTwbForm\View\Helper;

use Zend\Form\Element\File;

/**
 * Description of FormRowFileTwb
 * @author Nicolas Desprez <contact@dnconcept.fr>
 */
class FormRowFileTwb extends AbstractRowTwbHelper {

   private $options = array();
   private static $defaultOptions = array(
       "label" => null, // Label for row
       "change-btn-title" => "Modifier", // Title of button file in order to change existing File
       "file-template" => null // Valid callBack to render file
   );

   public function __construct() {
      self::$defaultOptions["file-template"] = function(File $file) {
         $fileValue = $file->getValue();
         return sprintf('<div class="form-control">%s</div>', $fileValue);
      };
   }

   public function __invoke(File $file = null, $options = null) {
      if (!$file) {
         return $this;
      }
      $view = $this->getView();
      $this->setElement($file);
      $this->setOptions((is_array($options) ? $options : array("label" => $options)));
      $fileValue = $file->getValue();
      $fileTemplate = $this->getOption("file-template");
      ob_start();
      echo $view->formLabelTwb($file);
      ?>
      <?php if ($fileValue == null): // Ajout d'un fichier     ?>
         <div class="<?= $this->getInputColumnClass() ?>">
            <?php echo $view->formFile($file); ?>
         </div>
      <?php elseif (is_array($fileValue)): // Fichier en cours de téléchargement  ?>
         <?php if ($fileValue["error"] === 0): ?>
            <div class="<?= $this->getInputColumnClass() ?>">
               <input type="hidden" name='old-file' value='<?= $fileValue["name"] ?>' />
               <div class="form-control-static">Fichier en cours de téléchargement : <?= $fileValue["name"] ?></div>
            </div>
            <div class="<?= $this->getInputColumnWithOffsetClass() ?>">
               <?php echo $view->formFile($file); ?>
            </div>
         <?php else: ?>
            <div class="<?= $this->getInputColumnClass() ?>">
               <?php echo $view->formFile($file); ?>
            </div>
         <?php endif; ?>
      <?php else:  // Changement du fichier ?>
         <?php $file->setAttribute("title", $this->getOption("change-btn-title")); ?>
         <div class="col-sm-6">
            <?php echo $fileTemplate($file) ?>
         </div>
         <div class="col-sm-3">
            <?php echo $view->formFile($file); ?>
         </div>
      <?php endif; ?>
      <?php
      return $this->renderGroup(ob_get_clean());
   }

   private function setOptions(array $options) {
      $this->options = array_merge(self::$defaultOptions, $options);
      if (!is_callable($this->getOption("file-template"))) {
         throw new \Exception("The option file-template must be a valid callback");
      }
      return $this;
   }

   private function getOption($name) {
      return isset($this->options[$name]) ? $this->options[$name] : null;
   }

}
