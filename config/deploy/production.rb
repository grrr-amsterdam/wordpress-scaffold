server 'grrr-4.cust.webslice.eu', user: 'grrr', roles: %w{web app db}
set :deploy_to, -> { '/home/grrr/html/calefax.nl' }
set :stage, :production
set :branch, :master

fetch(:default_env).merge!(wp_env: :staging)
