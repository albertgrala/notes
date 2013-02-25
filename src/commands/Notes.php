<?php

namespace Albertgrala\Notes\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

abstract class Notes extends Command {

  /**
   * The directory path
   *
   * @var string
   */
  protected $path ;

  /**
   * Default file name
   *
   * @var string 
   */
  protected $fileName = 'notes';

  /**
   * File extensions
   *
   * @var  string 
   */
  protected $fileExtension = 'json';

  /**
   * File
   *
   * @var string 
   */
  protected $file; 

  /**
   * The file content
   * @var string
   */
  protected $fileContent; 

  /**
   * Json format
   */
  protected $fileContentJson;

  /**

  /**
   * Date format
   *
   * @var string 
   */
  protected $dateFormat = "%d-%m-%Y";

  protected $scaffold = '{"notes":[]}';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->path = '';
    $this->file = $this->path . $this->fileName . '.' . $this->fileExtension;
    
    if (!\File::exists($this->file)) {
      file_put_contents($this->file, $this->scaffold);
    }
    $this->fileContent = \File::get($this->file);
    $this->fileContentJson = json_decode($this->fileContent);
    parent::__construct();
  }

  /**
   * Save the file
   * 
   * @return void
   */
  protected function saveFile()
  {
    \File::put($this->file, $this->indent(json_encode($this->fileContentJson)));
  }

  /**
   * Indents a flat JSON string to make it more human-readable.
   *
   * @param string $json The original JSON string to process.
   *
   * @return string Indented version of the original JSON string.
   */
  protected function indent($json) {

      $result      = '';
      $pos         = 0;
      $strLen      = strlen($json);
      $indentStr   = '  ';
      $newLine     = "\n";
      $prevChar    = '';
      $outOfQuotes = true;

      for ($i=0; $i<=$strLen; $i++) {

          // Grab the next character in the string.
          $char = substr($json, $i, 1);

          // Are we inside a quoted string?
          if ($char == '"' && $prevChar != '\\') {
              $outOfQuotes = !$outOfQuotes;
          
          // If this character is the end of an element, 
          // output a new line and indent the next line.
          } else if(($char == '}' || $char == ']') && $outOfQuotes) {
              $result .= $newLine;
              $pos --;
              for ($j=0; $j<$pos; $j++) {
                  $result .= $indentStr;
              }
          }
          
          // Add the character to the result string.
          $result .= $char;

          // If the last character was the beginning of an element, 
          // output a new line and indent the next line.
          if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
              $result .= $newLine;
              if ($char == '{' || $char == '[') {
                  $pos ++;
              }
              
              for ($j = 0; $j < $pos; $j++) {
                  $result .= $indentStr;
              }
          }
          
          $prevChar = $char;
      }

      return $result;
  }

}