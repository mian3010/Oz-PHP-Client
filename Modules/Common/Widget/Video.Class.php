<?php
class Widget_Video extends WidgetContainer {
	private $source;
	
	public function __construct($source) {
		$this->source = $source;
	}
	
	public function ToHtml() {
		return '<video controls><source src='.$this->source.'><video>';
	}
}