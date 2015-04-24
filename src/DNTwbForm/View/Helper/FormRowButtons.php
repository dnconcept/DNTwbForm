<?php

namespace DNTwbForm\View\Helper;

/**
 * Description of FormRowTwb
 * Permet de créer des boutons dans un formulaire horizontal
 * 
 * @author Nicolas Desprez <contact@dnconcept.fr>
 */
class FormRowButtons extends AbstractRowTwbHelper {

   public function __invoke() {
      //On récupère les arguments passés à la fonction
      $arguments = func_get_args();
      $html = "";
      //Pour chaque argument, 
      // -> si il s'agit d'une string, on récupére un bouton avec le label et des propriété par défaut
      // -> si il s'agit d'un tableau, on récupére un bouton avec le label et des attributs personnalisés
      foreach ($arguments as $arg) {
         $attributes = [];
         if (is_string($arg)) {
            $label = $arg;
            //Par défaut on renvoie un bouton type submit class btn-primary
            $attributes = ["type" => "submit", "class" => "btn btn-primary"];
         } else {
            $label = $arg["label"];
            unset($arg["label"]);
            $type = isset($arg["href"]) ? "link" : "button";
            $attributes = array_merge(["type" => $type, "class" => "btn btn-primary"], $arg);
         }
         $html .= $this->getButton($label, $attributes);
      }
      return $this->renderGroup(sprintf("<div class='{$this->getInputColumnWithOffsetClass()}'>%s</div>", $html));
   }

   private function getButton($label, $attributes = []) {
      $data = $this->serializeArray($attributes);
      switch ($attributes["type"]) {
         case "link":
            $template = sprintf("<a %s>%s</a>", $data, "%s");
            break;
         case "submit":
         case "button":
            $template = sprintf("<button %s>%s</button>", $data, "%s");
            break;
         default:
            $template = sprintf("<a %s>%s</a>", $data, "%s");
            break;
      }
      return sprintf($template, $label);
   }

   /**
    * Renvoie une chaine de caractère en liant les clés du tableau au valeur
    * @param array $attributes
    * @return string
    */
   private function serializeArray(array $attributes) {
      $pieces = [];
      foreach ($attributes as $key => $value) {
         if (!is_string($value)) {
            throw new \Exception("The value for formRowButtons must be a string !");
         }
         $pieces[] = "$key='$value'";
      }
      return implode(" ", $pieces);
   }

}
