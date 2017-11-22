set :application, fetch(:local_folder)
set :repo_url, 'git@bitbucket.org:careofhaus/repo.se.git'

set :local_url, 'careofhaus.se.dev'
set :local_folder, 'careofhaus.se'

set :staging_url, 'careofhaus.se.haus.se'
set :staging_plugins, 'nginx-helper redirection autodescription duracelltomi-google-tag-manager usersnap'
set :staging_server, 'careofhaus.se.haus.se'
set :staging_folder, 'docroot_stage'

set :production_url, 'careofhaus.se'
set :production_plugins, 'nginx-helper redirection autodescription duracelltomi-google-tag-manager'
set :production_server, 'careofhaus.se'
set :production_folder, 'docroot'

set :wpcli_local_url, fetch(:local_url)

#set :wpcli_args, "--network" # For multisites

# Branch options
# Prompts for the branch name (defaults to current branch)
#ask :branch, -> { `git rev-parse --abbrev-ref HEAD`.chomp }

# Hardcodes branch to always be master
# This could be overridden in a stage config file
set :branch, :master

set :deploy_to, -> { "/mnt/persist/www/#{fetch(:application)}" }

# Use :debug for more verbose output when troubleshooting
set :log_level, :info

set :composer_install_flags, '--optimize-autoloader'

# set :linked_files, fetch(:linked_files, []).push('.env', 'web/.htaccess')
set :linked_files, fetch(:linked_files, []).push('.env')
set :linked_dirs, fetch(:linked_dirs, []).push('web/app/uploads')

namespace :deploy do
  desc 'Restart application'
  task :restart do
    on roles(:app), in: :sequence, wait: 5 do
      # Clear nginx cache
      execute 'sudo /home/git/post-deploy.d/git-post-hook-nginx.sh'
      execute 'sudo /home/git/post-deploy.d/git-post-hook-php-fpm.sh'
    end
  end
end

# The above restart task is not run by default
# Uncomment the following line to run it on deploys if needed
after 'deploy:publishing', 'deploy:restart'

namespace :deploy do
  desc 'Update WordPress template root paths to point to the new release'
  task :update_option_paths do
    on roles(:app) do
      within fetch(:release_path) do
        if test :wp, :core, 'is-installed'
          [:stylesheet_root, :template_root].each do |option|
            # Only change the value if it's an absolute path
            # i.e. The relative path "/themes" must remain unchanged
            # Also, the option might not be set, in which case we leave it like that
            value = capture :wp, :option, :get, option, raise_on_non_zero_exit: false
            if value != '' && value != '/themes'
              execute :wp, :option, :set, option, fetch(:release_path).join('web/wp/wp-content/themes')
            end
          end
        end
      end
    end
  end
end

# The above update_option_paths task is not run by default
# Note that you need to have WP-CLI installed on your server
# Uncomment the following line to run it on deploys if needed
after 'deploy:publishing', 'deploy:update_option_paths'


namespace :deploy do

  # Theme path
  set :theme_path, Pathname.new('web/app/themes').join('careofhaus')

  # Local Paths
  set :local_theme_path, Pathname.new(File.dirname(__FILE__)).join('../').join(fetch(:theme_path))
  set :local_dist_path, fetch(:local_theme_path).join('dist')

  task :compile do
    run_locally do
      within fetch(:local_theme_path) do
        execute :gulp, '--production'
      end
    end
  end

  task :compile_local do
    run_locally do
      within fetch(:local_theme_path) do
        execute :gulp
      end
    end
  end

  task :copy do
    on roles(:web) do

      # Remote Paths (Lazy-load until actual deploy)
      set :remote_dist_path, -> { release_path.join(fetch(:theme_path)).join('dist') }

      info " Your local distribution path: #{fetch(:local_dist_path)} "
      info " Boom! Your remote distribution path: #{fetch(:remote_dist_path)} "
      info " Uploading files to remote "
      upload! fetch(:local_dist_path).to_s, fetch(:remote_dist_path), recursive: true
    end
  end

  task assets: %w(compile copy compile_local)
end

after 'deploy:updated', 'deploy:assets', 'deploy:compile_local'

##
# Deactivate plugins on pull
##

namespace :plugin do
    desc 'Enable/disabe plugins on pull'
    task :db_pull do
        run_locally do
            execute :wp, :plugin, :deactivate, fetch(:plugins)
        end
    end
end

##
# Activate plugins on push
##

namespace :plugin do
    desc 'Enable/disabe plugins on push'
    task :db_push do
        on roles(:app) do
            within release_path do
                execute :wp, :plugin, :activate, fetch(:plugins)
            end
        end
    end
end
