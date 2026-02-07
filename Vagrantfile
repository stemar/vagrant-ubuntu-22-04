require "yaml"
settings = YAML.load_file(File.join(File.expand_path(__dir__), "settings.yaml"))

Vagrant.require_version ">= 2.0.0"
Vagrant.configure("2") do |config|
  config.vm.define settings[:machine][:hostname]
  config.vm.hostname = settings[:machine][:hostname]
  config.vm.box = settings[:machine][:box]
  config.vm.provider "virtualbox" do |vb|
    vb.name   = settings[:machine][:hostname]
    vb.memory = settings[:machine][:memory]
    vb.cpus   = settings[:machine][:cpus]
  end

  host_http_port = settings[:forwarded_ports].find{|port| port[:guest] == 80}[:host]
  settings[:forwarded_ports].each do |port_options|
    config.vm.network :forwarded_port, **port_options
  end

  host_synced_folder = settings[:synced_folder].delete(:host)
  guest_synced_folder = settings[:synced_folder].delete(:guest)
  config.vm.synced_folder host_synced_folder, guest_synced_folder, **settings[:synced_folder]

  settings[:copy_files].each do |file_options|
    config.vm.provision :file, **file_options
  end unless settings[:copy_files].nil?

  config.vm.provision :shell, path: "provision.sh", env: {
    "HOST_HTTP_PORT"      => host_http_port,
    "GUEST_SYNCED_FOLDER" => guest_synced_folder,
    "TIMEZONE"            => settings[:machine][:timezone]
  }
end
