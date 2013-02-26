# Notes

Notes helps you manage your notes when developing an application

By default the information is stored in a json file **notes.json** in the project root.


## Installation

1. Update your composer.json to require `"albertgrala/notes": "dev-master"` .

```json
{
  "require": {
    "laravel/framework": "4.0.*",
    "albertgrala/notes": "dev-master"
  },
  "autoload": {
    "classmap": [
      "app/commands",
      "app/controllers",
      "app/models",
      "app/database/migrations",
      "app/database/seeds",
      "app/tests/TestCase.php"
    ]
  },
  "minimum-stability": "dev"
}
```

2. Run `composer update` in the Terminal
3. Add the NotesServiceProvider `'Albertgrala\Notes\NotesServiceProvider'` to the laravel providers array in the file `app/config/app.php`

```
'providers' => array(

    'Illuminate\Foundation\Providers\ArtisanServiceProvider',
    'Illuminate\Auth\AuthServiceProvider',
    'Illuminate\Cache\CacheServiceProvider',
    'Illuminate\Foundation\Providers\CommandCreatorServiceProvider',
    'Illuminate\Session\CommandsServiceProvider',
    'Illuminate\Foundation\Providers\ComposerServiceProvider',
    'Illuminate\Routing\ControllerServiceProvider',
    'Illuminate\Cookie\CookieServiceProvider',
    'Illuminate\Database\DatabaseServiceProvider',
    'Illuminate\Encryption\EncryptionServiceProvider',
    'Illuminate\Filesystem\FilesystemServiceProvider',
    'Illuminate\Hashing\HashServiceProvider',
    'Illuminate\Foundation\Providers\KeyGeneratorServiceProvider',
    'Illuminate\Log\LogServiceProvider',
    'Illuminate\Mail\MailServiceProvider',
    'Illuminate\Database\MigrationServiceProvider',
    'Illuminate\Pagination\PaginationServiceProvider',
    'Illuminate\Foundation\Providers\PublisherServiceProvider',
    'Illuminate\Queue\QueueServiceProvider',
    'Illuminate\Redis\RedisServiceProvider',
    'Illuminate\Auth\Reminders\ReminderServiceProvider',
    'Illuminate\Database\SeedServiceProvider',
    'Illuminate\Foundation\Providers\ServerServiceProvider',
    'Illuminate\Session\SessionServiceProvider',
    'Illuminate\Foundation\Providers\TinkerServiceProvider',
    'Illuminate\Translation\TranslationServiceProvider',
    'Illuminate\Validation\ValidationServiceProvider',
    'Illuminate\View\ViewServiceProvider',
    'Illuminate\Workbench\WorkbenchServiceProvider',
    'Albertgrala\Notes\NotesServiceProvider',

  )
```

## Commands

You can see the `notes` commands typing `php artisan` in the Terminal

Command | Description | Arguments | Options
--- | --- | --- | ---
`notes:add` | Add a new note to your notes file | `type` |
`notes:complete` | Mark a note as done | `id` |
`notes:delete` | Delete a note| `id` | `all`
`notes:show` | LList the notes | `type` | `all` , `done` , `today`

### notes:add

The argument `type` is **required**. Once entered the command, the terminal will ask you to describe your note

```bash
php artisan notes:add todo

```

The note will be saved in the `notes.json` file. By default the `type` is converted to uppercase.

Examples of `type` : `todo` , `optimize` , `fixme` , `bug`


### notes:show

To list your notes is as easy as typing `php artisan notes:show` , this will prompt all notes marked as uncompleted.

```bash
php artisan notes:show

```
You can filter your notes by `type` passing the argument. Use either the singular or plural form, uppercase or lowercase.

```bash
php artisan notes:show todo
php artisan notes:show todos
php artisan notes:show TODO
php artisan notes:show TODOS

```

#### Flags

The `--all` flag  will prompt the notes completed and uncompleted. In this example we will list all the bugs notes.

```bash
php artisan notes:show bugs --all
```

The `--done` flag  will filter and prompt only the notes marked as completed.

```bash
php artisan notes:show todos --done
```

The `--today` flag  will filter and prompt only the notes created today. In this example we will list all notes created today

```bash
php artisan notes:show --today
```

You can combine flags to filter even more.

```bash
php artisan notes:show todos --done --today
```

### notes:complete

Pass the note id to mark a note as completed. The note will be marked as done and the time saved as completed_at

```bash
php artisan notes:complete 1
```

### notes:delete

Pass the note id to delete a note

```bash
php artisan notes:delete 5
```

You can delete all the notes passing the flag `--all`

```bash
php artisan notes:delete --all
```

## Json file

The `notes.json` has the following structure
```json
{
  "notes":[
    {
      "id":1,
      "name":"Create the readme file",
      "type":"TODO",
      "done":true,
      "created_at":"2013-02-26 13:41:37",
      "completed_at":"2013-02-26 13:41:52"
    },
    {
      "id":2,
      "name":"Push notes changes to github",
      "type":"TODO",
      "done":true,
      "created_at":"2013-02-26 13:44:38",
      "completed_at":"2013-02-26 13:44:53"
    }
  ]
}
```