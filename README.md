## Quick Start

Run `composer create-project digitalunited/hausrock <path>` to just get a new copy of Hausrock locally.

## Deploy

Deploy to staging `bundle exec cap staging deploy`

Deploy to production `bundle exec cap production deploy`

Pull uploads from staging `bundle exec cap staging wpcli:uploads:rsync:pull`

Pull uploads from production `bundle exec cap production wpcli:uploads:rsync:pull`

Push uploads to staging `bundle exec cap staging wpcli:uploads:rsync:push`

Push uploads to production `bundle exec cap production wpcli:uploads:rsync:push`

Pull database from staging `Run db-pull-staging.sh located in the project root`

Pull database from production `Run db-pull-production.sh located in the project root`

Push database to staging `Run db-push-staging.sh located in the project root`

Push database to production `Run db-push-production.sh located in the project root`

## Installation/Usage

Composer's `create-project` command will automatically install the Bedrock project to a directory and run `composer install`.

The post-install script will automatically copy `.env.example` to `.env` and you'll be prompted about generating salt keys and appending them to your `.env` file.

Note: To generate salts without a prompt, run `create-project` with `-n` (non-interactive). You can also change the `generate-salts` setting in `composer.json` under `config` in your own fork. The default is `true`.

To skip the scripts completely, `create-project` can be run with `--no-scripts` to disable it.

1. Run `composer create-project roots/bedrock <path>` (`path` being the folder to install to)
