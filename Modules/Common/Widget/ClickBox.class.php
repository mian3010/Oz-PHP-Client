<?php
/**
 * Widget for displaying a clickbox. This is a box that is hidden until clicked
 */
class Widget_ClickBox extends Widget_Wrapper {
  public $border;
  public $text;

  /**
   * Constructor. Takes the text to display in link, and sets some standard values
   */
  public function __construct($text) {
    $this->text = $text;
    $this->border = '1px solid black';
    $this->classes[] = 'clickBoxWrapper';
  }

  /**
   * Override the base class GetCss to make sure that we have set our CSS when it is getted
   * @return The css contained in parent
   */
  public function GetCss() {
    $css = <<<CSS
    .clickBoxWrapper{
      margin-top: 13px;
      text-align: right;
      width: 300px;
      position: relative;
    }
    .clickBox{
      padding:10px;
      position:absolute;
      right: 0;
      border: {$this->border};
      background: black;
      border-radius: 8px;
      z-index: 200;
      margin-top: 18px;
    }
    .clicked{
      visibility:visible;
    }
    .unclicked{
      visibility:hidden;
    }
CSS;
    $this->AddCss($css);
    return parent::GetCss();
  }

  /**
   * Override the bae class GetJs to make sure that we have set our JS when it is getted
   * @return The js contained in parent
   */
  public function GetJs() {
    $js = <<<JAVASCRIPT
    $(window).load(function() {
      $(".clickBoxLabel").click(function() {
        if($(this).parent().find(".clickBox").hasClass("clicked")){ /* hide */
          $(this).parent().find(".clickBox").removeClass("clicked");
          $(this).parent().find(".clickBox").addClass("unclicked");
        } else { /* show */
          $(this).parent().find(".clickBox").removeClass("unclicked");
          $(this).parent().find(".clickBox").addClass("clicked");
        }
      });
      $('body').click(function(e) { /* click document to hide */
        if ($('.clickBox').hasClass('clicked')) {
          if ($(e.target).hasClass('clickBoxLabel')) return;
          if ($(e.target).hasClass('clickBox')) return;
          if ($(e.target).parents('.clickBox').length) return;
          $('.clickBox').removeClass('clicked');
          $('.clickBox').addClass('unclicked');
        }
      });
    });
JAVASCRIPT;
    $this->AddJs($js);
    return parent::GetJs();
  }

  public function ToHtml() {
    $wrap = new Widget_Wrapper();
    $wrap->classes += array('clickBox', 'unclicked');
    $label = new Widget_Label($this->text);
    $label->classes[] = 'clickBoxLabel';
    $wrap->widgets += $this->widgets;
    $this->widgets = array($label, $wrap);

    return parent::ToHtml();
  }
}
