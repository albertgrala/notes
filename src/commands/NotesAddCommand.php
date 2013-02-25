<?php

namespace Albertgrala\Notes\Commands;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class NotesAddCommand extends Notes {

  /**
   * The console command name.
   *
   * @var string
   */
  protected $name = 'notes:add';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Add a new note to your notes file';

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
    $name = $this->ask('Describe your note');
    $type = $this->argument('type');
    
    // get the next id
    $id = $this->getNextID($this->fileContentJson->notes);
    $this->fileContentJson->notes[]= ['id'=>$id,'name'=>$name, 'type'=>strtoupper($type),'done'=>false, 'created_at' =>date('Y-m-d H:i:s')];
    
    $this->saveFile();
  }

  /**
   * Get the next id of a set of items
   * 
   * @param  array $items
   * @return integer
   */
  protected function getNextID($items)
  {
    // Default value
    $max = 1;
    if (count($items)> 0) {
      foreach($items as $item) {
        $max = ($item->id >= $max) ? $item->id+1 : $max;
      }
    }
    return $max;
  }

  /**
   * Get the console command arguments.
   *
   * @return array
   */
  protected function getArguments()
  {
    return array(
      array('type', InputArgument::REQUIRED, 'The type of the note'),
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
    );
  }

}