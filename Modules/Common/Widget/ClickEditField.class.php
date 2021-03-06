<?php
/*
 * Widget for displaying a clickeditfield. This is a field that can be edited when clicked
 */
class Widget_ClickEditField extends Widget_Wrapper {
  private $handler = '';
  private $readonly;
  private $label;
  private $field = null;
  private $value;
  public function __construct($value = '', $readonly = false){
    $this->value = $value;
    $this->readonly = $readonly;
  }

  /**
   * Override the base class GetJs to make sure that we have set our JS when it is getted
   * @return The js contained in parent
   */
  public function GetJs() {
    $js = <<<JAVASCRIPT
      $(window).load(function() {
        $('.click-edit-field .field-value').click(function() {
        if ( $(this).parent().find('.field').length) {
            $(this).css('display', 'none');
            $(this).parent().find('.field')
              .val($(this).text())
              .css('display', '')
              .focus();
          }
        });
        $('.click-edit-field .field').blur(function() {
          $(this).css('display', 'none');
          $(this).parent().find('.field-value')
            .text($(this).val())
            .css('display', '')
        });
      });
JAVASCRIPT;
    $this->AddJs($js);
    return parent::GetJs();
  }

  /**
   * Override the base class GetCss to make sure that we have set our CSS when it is getted
   * @return The css contained in parent
   */
  public function GetCss() {
    $css = <<<CSS
      .click-edit-field.empty .field-value {
        display: inline-block;
        height: 1em;
        width: 150px;
      }
      .click-edit-field {
        display: inline-block;
      }
CSS;
    $this->AddCss($css);
    return parent::GetCss();
  }

  public function ToHtml() {
    $this->classes[] = 'click-edit-field';
    if (trim($this->value) == '') $this->classes[] = 'empty';

    //Edit field
    $fl = new Widget_Label($this->value);
    $fl->classes[] = 'field-value';
    if ($this->field == null) $fi = new Widget_InputField();
    else $fi = $this->field;
    $fi->value = $this->value;
    $fi->classes[] = 'field';
    $fi->style = "display:none;";
    $fi->name = $this->name;
    $this->name = '';

    //Add to wrapper
    $this->widgets[] = $fl;
    if(!$this->readonly) $this->widgets[] = $fi;

    return parent::ToHtml();
  }
}
