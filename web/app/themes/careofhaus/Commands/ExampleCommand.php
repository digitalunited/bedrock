<?php
class ExampleCommand extends WP_CLI_Command
{
    public function commandName()
    {
        WP_CLI::success("Success");
    }

}
WP_CLI::add_command('example', 'ExampleCommand');
