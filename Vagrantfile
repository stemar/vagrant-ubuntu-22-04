require 'yaml'
dir = File.join(File.dirname(File.expand_path(__FILE__)))
settings = YAML.load_file("#{dir}/settings.yaml")

Vagrant.require_version ">= 2.0.0"
Vagrant.configure("2") do |config|
  config.vm.define settings[:machine][:hostname]

  config.vm.box = settings[:machine][:box]

  config.vm.provider "virtualbox" do |vb|
    vb.name   = settings[:machine][:hostname]
    vb.memory = settings[:machine][:memory]
    vb.cpus   = settings[:machine][:cpus]
  end

  config.vm.hostname = settings[:machine][:hostname]

  settings[:forwarded_ports].each do |port_options|
    config.vm.network :forwarded_port, port_options
  end

  config.vm.synced_folder settings[:synced_folder][:host], settings[:synced_folder][:guest], owner: "vagrant", group: "vagrant"

  settings[:copy_files].each do |file_options|
    config.vm.provision :file, file_options
  end unless settings[:copy_files].nil?

  config.vm.provision :shell, path: "provision.sh", env: {
    "FORWARDED_PORT_80"   => settings[:forwarded_ports].find{|port| port[:guest] == 80}[:host],
    "GUEST_SYNCED_FOLDER" => settings[:synced_folder][:guest],
    "PHP_ERROR_REPORTING" => settings[:php_error_reporting],
    "TIMEZONE"            => settings[:machine][:timezone]
  }
end
