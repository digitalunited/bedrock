set :stage, :production
set :application, 'docroot'
server 'hausrock.se', user: 'deploy', roles: %w{web app db}
set :wpcli_remote_url, 'hausrock.se'
fetch(:default_env).merge!(wp_env: :production)
