<?php

namespace Albertgrala\Notes\Commands;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class NotesDeleteCommand extends Notes {

  /**
   * The console command name.
   *
   * @var string
   */
  protected $name = 'notes:delete'; 
  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Delete a note'; 
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
    $tmp = [];
    if ($this->option('all') === true) {
        $this->fileContentJson->notes = [];
        $this->saveFile();
        $this->info("All Notes deleted");		
      return;
    }
    $id = $this->argument('id'); 
    if ($id) {
      foreach ($this->fileContentJson->notes as $item) {
        if ($item->id != $id) {
            $tmp[]=$item;
        }
      }
      $this->fileContentJson->notes = $tmp;
      $this->saveFile();
      $this->info("Note #{$id} deleted");
      return;
    }

    $this->info("No notes deleted");
  }

  /**
   * Get the console command arguments.
   *
   * @return array
   */
  protected function getArguments()
  {
    return array(
      array('id', InputArgument::OPTIONAL, 'The note id.'),
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
      array('all', null, InputOption::VALUE_NONE, 'Delete all the notes.', null),
    );
  }

}