module Slackistrano
  class CustomMessaging < Messaging::Base

    @icon_emoji
    @version

    def initialize(env: nil, team: nil, channel: nil, token: nil, webhook: nil, icon_emoji: nil)
      super(env: env, team: team, channel: channel, token: token, webhook: webhook)
      @icon_emoji = icon_emoji
      @version = `git describe #{fetch(:branch)} --tags --always`.strip!
    end

    def icon_emoji
      if @icon_emoji.nil?
        nil
      else
        @icon_emoji
      end
    end

    # Send failed message to #ops. Send all other messages to default channels.
    # The #ops channel must exist prior.
    #def channels_for(action)
      #if action == :failed
        #"#ops"
      #else
        #super
      #end
    #end

    # Fancy starting message.
    def payload_for_starting
      {
        text: "*#{deployer}* has started deploying branch *#{fetch(:branch)}* to *#{stage}*"
      }
    end

    # Suppress updating message.
    def payload_for_updating
      nil
    end

    # Suppress reverting message.
    def payload_for_reverting
      {
        text: ":warning: *#{application}* on *#{stage}* was rolled back by *#{deployer}*"
      }
    end

    # Fancy updated message.
    # See https://api.slack.com/docs/message-attachments
    def payload_for_updated
      {
        text: "*#{application}* *#{@version}* (*#{fetch(:branch)}*) was deployed to *#{stage}* by *#{deployer}*"
      }
    end

    # Default reverted message.  Alternatively simply do not redefine this
    # method.
    def payload_for_reverted
      nil
    end

    # Slightly tweaked failed message.
    # See https://api.slack.com/docs/message-formatting
    def payload_for_failed
      nil
      #payload = super
      #payload[:text] = "OMG :fire: #{payload[:text]}"
      #payload
    end

    # Override the deployer helper to pull the full name from the password file.
    # See https://github.com/phallstrom/slackistrano/blob/master/lib/slackistrano/messaging/helpers.rb
    def deployer
      begin
        Etc.getpwnam(ENV['USER']).gecos
      rescue
        ENV['USER']
      end
    end
  end
end
