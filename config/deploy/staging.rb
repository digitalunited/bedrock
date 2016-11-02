set :stage, :staging
set :application, fetch(:staging_folder)
server fetch(:staging_server), user: 'deploy', roles: %w{web app db}
set :wpcli_remote_url, fetch(:staging_url)
fetch(:default_env).merge!(wp_env: :staging)

namespace :plugin do
    desc 'Enable/disabe plugins'
    task :staging_push do
        on roles(:app) do
            within release_path do
                execute :wp, :plugin, :activate, fetch(:staging_plugins)
            end
        end
    end
end

after 'wpcli:db:push', 'plugin:staging_push'

namespace :plugin do
    desc 'Enable/disabe plugins'
    task :staging_pull do
        run_locally do
            execute :wp, :plugin, :deactivate, fetch(:staging_plugins)
        end
    end
end

after 'wpcli:db:pull', 'plugin:staging_pull'