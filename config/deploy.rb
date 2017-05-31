set :application, 'wordpress-scaffold'
set :repo_url, 'git@github.com:grrr-amsterdam/wordpress-scaffold'
set :ssh_options, {
  forward_agent: true,
}
set :keep_releases, 5
set :log_level, :info
set :branch, :master

# Linked directories
set :linked_dirs, fetch(:linked_dirs, []).push(
  'web/app/uploads',
  'web/app/w3tc-config'
)

# Linked files
set :linked_files, fetch(:linked_files, []).push(
  '.env',
  'web/.htaccess',
  'web/app/advanced-cache.php',
  'web/app/db.php'
)

# Run all tasks
namespace :deploy do

  after :updated do

    invoke :composer_install_root
    invoke :composer_install_theme

  end

  after :publishing do

    invoke :fpm_reload

  end

  after :setup do

    # copy .htaccess
    # install wp-cli
    # install composer
    # install crontab (?)
    # install cachetool (?)

  end

end
