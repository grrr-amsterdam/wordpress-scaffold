set :application, 'wordpress-scaffold'
set :repo_url, 'git@github.com:grrr-amsterdam/wordpress-scaffold'
set :ssh_options, {
  forward_agent: true,
}
set :keep_releases, 3
set :log_level, :info
set :branch, :master

# Composer settings
set :composer_install_flags, '--no-dev --no-interaction --prefer-dist --optimize-autoloader'

# Linked directories
set :linked_dirs, fetch(:linked_dirs, []).push(
  'web/app/uploads',
  'web/app/w3tc-config'
)

# Linked files
set :linked_files, fetch(:linked_files, []).push(
  '.env',
  'wp',
  'web/.htaccess',
  'web/app/advanced-cache.php',
  'web/app/db.php'
)

# Slackistrano
set :slackistrano, {
  klass: Slackistrano::CustomMessaging,
  channel: ENV['SLACK_DEPLOY_CHANNEL'],
  webhook: ENV['SLACK_WEBHOOK_URL'],
  icon_emoji: ':rocket:'
}

# Deploy tasks
# Note: several tasks run automatically
namespace :deploy do

  before :starting,    'deploy:set_branch'
  before :starting,    'git:verify_branch'

  after  :started,     'composer:config'
  after  :started,     'wp_cli:config'
  after  :started,     'assets:verify'
  after  :started,     'assets:build'

  after  :updated,     'assets:push'

  before :publishing,  'versioning:create_file'

  # after :published,    'server:fpm_reload'

  after :failed,       'deploy:remove_failed_release'

end

# Setup tasks
namespace :deploy do

  task :setup do
    invoke 'git:wrapper'
    invoke 'git:check'

    invoke 'deploy:check:directories'
    invoke 'deploy:check:linked_dirs'
    invoke 'deploy:check:make_linked_dirs'

    invoke 'setup:copy_dotenv'
    invoke 'setup:copy_htaccess'
    invoke 'setup:copy_w3tc_files'

    invoke 'deploy:check:linked_files'

    invoke 'composer:install_executable'
    invoke 'wp_cli:setup'
  end

end
