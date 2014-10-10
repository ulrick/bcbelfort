<?php
class PressPixelsAdmin {
  /*
   * Function that creates an html textbox
   */
  function makeHtmlFormField( $type, $name, $value='', $size=50, $label='', $extra='', $itoggle=false, $path='' ) {
    $html_text = '';
    switch( $type ) {
      case 'text':
        $html_text .= "<input type='{$type}' name='{$name}' value='{$value}' size='{$size}' {$extra} />";
        break;
      case 'checkbox':
        $checked       = $value == 1? "checked=\"true\"": '';
        $hidden_field  = '';
        $hidden_prefix = '';
        $safe_name    = str_replace( array( '_', ' ' ), '-', $name );
        if( $itoggle ) {
          $hidden_prefix = 'checkbox-';
          $hidden_field  = "<input type=\"hidden\" id=\"cb-{$safe_name}\" name=\"{$name}\" value=\"{$value}\" />";
        }
        $html_text .= "&nbsp;<input type=\"{$type}\" name=\"{$hidden_prefix}{$name}\" id=\"{$hidden_prefix}{$safe_name}\" value=\"1\" {$checked} {$extra} />&nbsp;{$label}{$hidden_field}";
        break;
      case 'filelist':
        $html_text = "<select name='{$name}' {$extra}>";
        $files = glob( "$path/*" );
        foreach( $files as $file ) {
          $filename = explode( "/", $file );
          $filename = $filename[sizeof($filename)-1];
          $selected = $filename == $value ? "selected='true'" : "";
          $html_text .= "<option value='{$filename}' {$selected}>{$filename}</option>";
        }
        $html_text .= "</select>";
        break;
    }
    return $html_text;
  }
}