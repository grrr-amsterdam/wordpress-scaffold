server 'xxx', user: 'xxx', roles: %w{web app db}
set :deploy_to, -> { '/home/xxx/html/staging.xxx.xxx/' }
set :stage, :staging
set :branch, :develop

fetch(:default_env).merge!(wp_env: :staging)
