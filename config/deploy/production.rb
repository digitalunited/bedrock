set :stage, :production
set :application, fetch(:production_folder)
server fetch(:production_server), user: 'deploy', roles: %w{web app db}
set :wpcli_remote_url, fetch(:production_url)
fetch(:default_env).merge!(wp_env: :production)

namespace :plugin do
    desc 'Enable/disabe plugins on push'
    task :production_push do
        on roles(:app) do
            within release_path do
                execute :wp, :plugin, :activate, fetch(:production_plugins)
            end
        end
    end
end

after 'wpcli:db:push', 'plugin:production_push'

namespace :plugin do
    desc 'Enable/disabe plugins on pull'
    task :production_pull do
        run_locally do
            execute :wp, :plugin, :deactivate, fetch(:production_plugins)
        end
    end
end

after 'wpcli:db:pull', 'plugin:production_pull'
