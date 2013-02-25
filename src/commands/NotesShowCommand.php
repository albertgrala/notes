<?php

namespace Albertgrala\Notes\Commands;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class NotesShowCommand extends Notes {

  /**
   * The console command name.
   *
   * @var string
   */
  protected $name = 'notes:show';
  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'List the notes';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  } 
  /**
   * Execute the console command.
   *
   * @return void
   */
  public function fire()
  {
    $this->parseFile();
  } 
  /**
   * Parse the document
   *
   * @return  void
   */
  protected function parseFile()
  { 
    if (count($this->fileContentJson->notes) == 0) {
        $this->info('The notes list is empty');
        return;
    } else {

      $type = $this->argument('type');
      if ($type) {
          $this->filterItems('type',$type);
      }

      $this->filterByArguments();
      $this->displayItems();
    }
  } 
  /**
   * Filter the items by the arguments used
   * 
   * @return void
   */
  protected function filterByArguments()
  {
    $options = $this->option();  
    if (!$options['all'] && !$options['done']) {
        $this->FilterItems('done',false);
    }
    if ($options['done']) {
        $this->FilterItems('done',true);
    }
    if ($options['today']) {
        $this->FilterItems('created_at',date('Y-m-d'));
    }
  } 

  /**
   * Filter the items by a field
   * 
   * @param  string $field  
   * @param  string $attr 
   * @return  void
   */
  protected function FilterItems($field = 'type',$attr)
  {
    $temp = [];

    foreach ($this->fileContentJson->notes as $item) {
      if (isset($item->$field) && $this->attrContains($item->$field,$attr)) {
          $temp[] = $item; 
      }
    }

    $this->fileContentJson->notes = $temp;
  } 

  /**
   * Check if the $attr is a plural form of $field, case insensitive,
   * or if the $field contains the $attr
   * 
   * @param  string $field
   * @param  string $attr  
   * @return boolean
   */
  protected function attrContains($field,$attr){
    return  ($field == \Str::singular(strtoupper($attr)) || $field == \Str::singular($attr) ||
             $field == strtoupper($attr) || \Str::contains($field,$attr));
  } 

  /**
   * Display the items in the console
   * 
   * @return void
   */
  protected function displayItems(){
    if (count($this->fileContentJson->notes) == 0) {
        $this->info("There are no items to show"); return;
     }

    foreach ($this->fileContentJson->notes as $item) {
        $result  = " * ". "[$item->type] " . $item->id . ' - ' . $item->name;
        $result .= isset($item->created_at) ? " | ". strftime( $this->dateFormat, strtotime( $item->created_at ) )  : "" ;
        if($item->done){
          $this->info($result);
        }else
        {
          $this->comment($result);
        }
      }
  } 

  /**
   * Get the console command arguments.
   *
   * @return array
   */
  protected function getArguments()
  {
    return array(
      array('type', InputArgument::OPTIONAL, 'Type of notes'),
    );
  } 
  /**
   * Get the console command options.
   *
   * @return array
   */
  protected function getOptions()
  {
    return array(
      array('all', null, InputOption::VALUE_NONE, 'List all notes', null),
      array('today', null, InputOption::VALUE_NONE,'List only the notes created today',null),
      array('done', null, InputOption::VALUE_NONE,'List only the notes done',null),
    );
  }

}