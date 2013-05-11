<?php

abstract class Widget {
  public $classes = array(); // Array of HTML classes
  protected $atrbs = array();
  private $js = array();
  private $css = array();
  private $jsFiles = array();
  private $cssFiles = array();

  public static function register() {
    spl_autoload_register("Widget::WidgetAutoload");
  }
  public static function WidgetAutoload($class) {
    $prefix = "Widget_";
    
    //Should the class being loaded be handled by us?
    if (strpos($class, $prefix) == 0) {

      //Path to class file
      $classFile = "Modules/Common/Widget/".substr($class, strlen($prefix)).".class.php";
      
      //Include the file
      if (@include_once($classFile)) return TRUE;
    }
    //Class is not part of widgets
    return FALSE;
  }

  public function __set($k, $v){
    $this->atrbs[$k] = $v;
  }

  public function __get($k) {
    return $this->atrbs[$k];
  }

  protected function GetAttributes(){
    $this->atrbs['id'] = $this->id;
    $this->atrbs['class'] = $this->GetClasses();
    ksort($this->atrbs);
    $atrb = '';
    foreach ($this->atrbs as $key => $value) $atrb .= $key . '="' . $value . '" ';
    return trim($atrb);
  }

  protected function GetClasses() {
    $classesStr = '';
    foreach ($this->classes as $c) $classesStr .= $c.' ';
    return trim($classesStr);
  }

  protected function AddJs($js, $id = null) {
    if ($id == null) $id = md5($js);
    $this->js[$id] = $js;
  }

  protected function AddCss($css, $id = null) {
    if ($id == null) $id = md5($css);
    $this->css[$id] = $css;
  }

  protected function AddJsFile($path, $id = null) {
    if ($id == null) $id = $path;
    $this->jsFiles[$path] = $path;
  }
  
  protected function AddCssFile($path, $id = null) {
    if ($id == null) $id = $path;
    $this->cssFiles[$path] = $path;
  }

  public function GetJs() {
    return $this->js;
  } 

  public function GetCss() {
    return $this->css;
  }

  public function GetJsFiles() {
    return $this->jsFiles;
  }
  
  public function GetCssFiles() {
    return $this->cssFiles;
  }

  public abstract function ToHtml();
}
