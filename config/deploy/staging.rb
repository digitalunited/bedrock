set :stage, :staging
set :application, fetch(:staging_folder)
server fetch(:staging_server), user: 'deploy', roles: %w{web app db}
set :wpcli_remote_url, fetch(:staging_url)
fetch(:default_env).merge!(wp_env: :staging)

set :plugins, fetch(:staging_plugins)
after 'wpcli:db:push', 'plugin:db_push'

set:plugins, fetch(:staging_plugins)
after 'wpcli:db:pull', 'plugin:db_pull'
