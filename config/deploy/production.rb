server 'xxx', user: 'xxx', roles: %w{web app db}
set :deploy_to, -> { '/home/xxx/html/xxx.xxx/' }
set :stage, :production
set :branch, :master

fetch(:default_env).merge!(wp_env: :staging)
