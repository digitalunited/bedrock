set :stage, :staging
set :application, 'docroot_stage'
server 'hausrock.se.haus.se', user: 'deploy', roles: %w{web app db}
set :wpcli_remote_url, 'hausrock.se.haus.se'
fetch(:default_env).merge!(wp_env: :staging)
