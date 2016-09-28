## Installation

1. Run `composer create-project digitalunited/hausrock <path>` to just get a new copy of Hausrock locally.
2. Run `setup.sh` located in the root of the project and follow the instructions.

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
