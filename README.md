## Quick Start

Run `composer create-project digitalunited/hausrock <path>` to just get a new copy of Hausrock locally.

## Deploy

Deploy to staging `bundle exec cap staging deploy`

Deploy to production `bundle exec cap production deploy`

Pull uploads from staging `bundle exec cap staging wpcli:uploads:rsync:pull`

Pull uploads from production `bundle exec cap production wpcli:uploads:rsync:pull`

Push uploads to staging `bundle exec cap staging wpcli:uploads:rsync:push`

Push uploads to production `bundle exec cap production wpcli:uploads:rsync:push`

Pull database from staging `bundle exec cap staging wpcli:db:pull`

Pull database from production `bundle exec cap production wpcli:db:pull`

Push database to staging `bundle exec cap staging wpcli:db:push`

Push database to production `bundle exec cap production wpcli:db:push`

## Installation/Usage

Composer's `create-project` command will automatically install the Bedrock project to a directory and run `composer install`.

The post-install script will automatically copy `.env.example` to `.env` and you'll be prompted about generating salt keys and appending them to your `.env` file.

Note: To generate salts without a prompt, run `create-project` with `-n` (non-interactive). You can also change the `generate-salts` setting in `composer.json` under `config` in your own fork. The default is `true`.

To skip the scripts completely, `create-project` can be run with `--no-scripts` to disable it.

1. Run `composer create-project roots/bedrock <path>` (`path` being the folder to install to)
2. Edit `.env` and update environment variables:
  * `DB_NAME` - Database name
  * `DB_USER` - Database user
  * `DB_PASSWORD` - Database password
  * `DB_HOST` - Database host (defaults to `localhost`)
  * `WP_ENV` - Set to environment (`development`, `staging`, `production`, etc)
  * `WP_HOME` - Full URL to WordPress home (http://example.com)
  * `WP_SITEURL` - Full URL to WordPress including subdirectory (http://example.com/wp)
3. Add theme(s)
4. Set your Nginx or Apache vhost to `/path/to/site/web/` (`/path/to/site/current/web/` if using Capistrano)
5. Access WP Admin at `http://example.com/wp/wp-admin`
