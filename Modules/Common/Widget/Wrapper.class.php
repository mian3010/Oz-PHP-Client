<?php

class Common_Widget_Wrapper extends WidgetContainer {
  public function ToHtml() {
    return '<div ' . $this->GetAttributes() . $this->GetClasses() . '">'.$this->ChildrenToHtml().'</div>';
  }
}
