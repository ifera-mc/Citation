# Citation

A virion for PocketMine-MP developers aiming to assist registration of commands with added support for registering and executing SubCommands.

# Documentation

First of all you need to make a variable (save it somewhere since you might need it elsewhere).<br />

```php
    $citation = new Citation(Plugin $plugin, ?string $prefix);
```

- `$plugin` is pretty self explanatory.
- `$prefix` is the text (that if set) would appear before the messages sent to the command sender.

## Commands

Citation provides a neat and easy to use API for developers for registering commands.

### Class

- Your command class must extend `JackMD\Citation\Command\BaseCommand` class in order for it to be registered.
- Refer to the class for all the API methods it has.

### Registering

- To register the command get handler from citation and register the command class.

```php
    $citation->getHandler()->registerCommand(BaseCommand $command): void;
```

- `$command` being the command class you want to register.

- For more API methods please refer to `JackMD\Citation\Handler` class.

## SubCommands

Citation provides a neat and easy way for plugins to register sub commands in separate classes.

### Class

- Your SubCommand class must extend `JackMD\Citation\Command\SubCommand` class.
- You may refer to the aforementioned class for all the API methods it hides.

### Registering

- You need to register the SubCommand from the same command class that extends BaseCommand class like so.

```php
    $this->registerSubCommand(SubCommand $command): void;
```

- This will register the SubCommand for the command.

### Executing

- For executing the sub commands in the `onCommand()` method of your BaseCommand add 

```php
    $this->executeSubCommand(CommandSender $sender, array $args): void;
```

- This will check if the subcommand or its alias exist and execute it. If it doesn't then it will send the error to the command sender.
- It will also check if the sender has the permission to use the subcommand and notify if he doesn't.

### Defaults

Some default commands are provided within Citation for aiding the developer.

#### Help SubCommand

- A default help sub command is provided within Citation. You need not to register the help sub command yourself.

```php
    $help = new JackMD\Citation\Command\Defaults\HelpSubCommand(BaseCommand $command, string $headerName, string $permission, string $usage, array $aliases = []);
```

- `$command` being the command whose sub command you want to add.
- `$headerName` is the text that would appear on the top message of the help command when executed.
- `$permission`, `$usage` and `$alias` are pretty self explanatory.

### Note(s)

- Hopefully I mentioned every required detail.
- For any feature additions or bug reports to open an issue.
- PRs are always welcomed.

