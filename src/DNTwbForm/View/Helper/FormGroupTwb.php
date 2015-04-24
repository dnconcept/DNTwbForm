<?php

namespace DNTwbForm\View\Helper;

/**
 * Description of FormGroupTwb
 *
 * @author Nicolas Desprez <contact@dnconcept.fr>
 */
class FormGroupTwb extends AbstractRowTwbHelper {

   public function __invoke($string = null) {
      if (!$string) {
         return $this;
      }
      return $this->renderGroup($string);
   }

}
