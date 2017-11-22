set :stage, :production
set :application, fetch(:production_folder)
server fetch(:production_server), user: 'deploy', roles: %w{web app db}
set :wpcli_remote_url, fetch(:production_url)
fetch(:default_env).merge!(wp_env: :production)

set :plugins, fetch(:production_plugins)
after 'wpcli:db:push', 'plugin:db_push'

set:plugins, fetch(:production_plugins)
after 'wpcli:db:pull', 'plugin:db_pull'
