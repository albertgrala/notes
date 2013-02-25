<?php

namespace Albertgrala\Notes\Commands;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class NotesCompleteCommand extends Notes {

  /**
   * The console command name.
   *
   * @var string
   */
  protected $name = 'notes:complete';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Mark a note as done';


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
    $id = $this->argument('id');

    foreach ($this->fileContentJson->notes as $item) {
      if ($item->id == $id ) {
          $item->done = true;
          $item->completed_at = date('Y-m-d H:i:s');
      }
    }
    $this->saveFile();
    $this->info("Note #{$id} done");
  }


  /**
   * Get the console command arguments.
   *
   * @return array
   */
  protected function getArguments()
  {
    return array(
      array('id', InputArgument::REQUIRED, 'The note id.'),
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