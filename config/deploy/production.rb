set :stage, :production

# Simple Role Syntax
# ==================
#role :app, %w{deploy@example.com}
#role :web, %w{deploy@example.com}
#role :db,  %w{deploy@example.com}


set :linked_files, fetch(:linked_files, []).push('web/app/plugins/w3tc-wp-loader.php', 'web/app/advanced-cache.php', 'web/app/object-cache.php', 'web/app/db.php')
set :linked_dirs, fetch(:linked_dirs, []).push('web/app/cache', 'web/app/plugins/cache', 'web/app/w3tc-config')

# Extended Server Syntax
# ======================
server 'example.com', user: 'deploy', roles: %w{web app db}

# you can set custom ssh options
# it's possible to pass any option but you need to keep in mind that net/ssh understand limited list of options
# you can see them in [net/ssh documentation](http://net-ssh.github.io/net-ssh/classes/Net/SSH.html#method-c-start)
# set it globally
#  set :ssh_options, {
#    keys: %w(~/.ssh/id_rsa),
#    forward_agent: false,
#    auth_methods: %w(password)
#  }

fetch(:default_env).merge!(wp_env: :production)

