class CreateSmsserverOutMessages < ActiveRecord::Migration
  def self.up
    create_table :smsserver_out_messages do |t|

      t.timestamps
    end
  end

  def self.down
    drop_table :smsserver_out_messages
  end
end
