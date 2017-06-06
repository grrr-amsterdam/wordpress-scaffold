set :application, 'wordpress-scaffold'
set :repo_url, 'git@github.com:grrr-amsterdam/wordpress-scaffold'
set :ssh_options, {
  forward_agent: true,
}
set :keep_releases, 3
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

  task :updated do
    invoke :wp_cli_map_command
    invoke :composer_map_command

    invoke :composer_install_root
    invoke :composer_install_themes
  end

  task :publishing do
    # invoke :fpm_reload
  end

  task :setup do
    invoke 'git:wrapper'
    invoke 'git:check'

    invoke 'deploy:check:directories'
    invoke 'deploy:check:linked_dirs'
    invoke 'deploy:check:make_linked_dirs'

    invoke :copy_dotenv
    invoke :copy_htaccess
    invoke :copy_w3tc_files
    invoke :make_w3tc_config_dir

    invoke :composer_setup
    invoke :wp_cli_setup

    invoke 'deploy:check:linked_files'
  end

end
