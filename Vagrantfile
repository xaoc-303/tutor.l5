# -*- mode: ruby -*-
# vi: set ft=ruby :

require 'json'
require 'yaml'

VAGRANTFILE_API_VERSION ||= "2"

confDir = $confDir ||= File.expand_path(File.dirname(__FILE__))
provisionDir = $provisionDir ||= File.join(confDir, ".provision")
homesteadDir = $homesteadDir ||= File.join(provisionDir, "homestead")

homesteadYamlPath = File.join(confDir, "Homestead.yaml")
homesteadJsonPath = File.join(confDir, "Homestead.json")
afterScriptPath = File.join(provisionDir, "after.sh")
customizationScriptPath = File.join(provisionDir, "user-customizations.sh")
aliasesPath = File.join(homesteadDir, "resources", "aliases")
supervisorConfigScriptPath = File.join(provisionDir, "supervisor", "configure.sh")

require File.join(homesteadDir, "scripts", "homestead.rb")

Vagrant.require_version '>= 2.1.0'

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
    if File.exist? aliasesPath then
        config.vm.provision "file", source: aliasesPath, destination: "/tmp/bash_aliases"
        config.vm.provision "shell" do |s|
            s.inline = "awk '{ sub(\"\r$\", \"\"); print }' /tmp/bash_aliases > /home/vagrant/.bash_aliases && chown vagrant:vagrant /home/vagrant/.bash_aliases"
        end
    end

    if File.exist? homesteadYamlPath then
        settings = YAML::load(File.read(homesteadYamlPath))
    elsif File.exist? homesteadJsonPath then
        settings = JSON.parse(File.read(homesteadJsonPath))
    else
        abort "Homestead settings file not found in #{confDir}"
    end

    Homestead.configure(config, settings)

    # Give VM 1/4 system memory & access to half of cpu cores on the host
    config.vm.provider "virtualbox" do |v|
        host = RbConfig::CONFIG['host_os']

        if host =~ /darwin/
            cpus = `sysctl -n hw.ncpu`.to_i
            # sysctl returns Bytes and we need to convert to MB
            mem = `sysctl -n hw.memsize`.to_i / 1024
        elsif host =~ /linux/
            cpus = `nproc`.to_i
            # meminfo shows KB and we need to convert to MB
            mem = `grep 'MemTotal' /proc/meminfo | sed -e 's/MemTotal://' -e 's/ kB//'`.to_i
        elsif host =~ /mswin|mingw|cygwin/
            # Windows code via https://github.com/rdsubhas/vagrant-faster
            cpus = `wmic cpu Get NumberOfCores`.split[1].to_i
            mem = `wmic computersystem Get TotalPhysicalMemory`.split[1].to_i / 1024
        else # Unrecognized OS
            cpus = 1
            mem = 1024
        end

        cpus = cpus / 2 if cpus > 1
        mem = mem / 1024 / 4 if mem > 2048

        v.customize ["modifyvm", :id, "--memory", mem]
        v.customize ["modifyvm", :id, "--cpus", cpus]
    end

    if File.exist? afterScriptPath then
        config.vm.provision "shell", path: afterScriptPath, privileged: false, keep_color:true, name: "After installation script"
    end

    if File.exist? customizationScriptPath then
        config.vm.provision "shell", path: customizationScriptPath, privileged: false, keep_color: true, name: "User customizations script"
    end

    if File.exist? supervisorConfigScriptPath then
        config.vm.provision "shell", path: supervisorConfigScriptPath, keep_color:true, name: "Supervisor configuration"
    end

    if Vagrant.has_plugin?('vagrant-hostsupdater')
        config.hostsupdater.aliases = settings['sites'].map { |site| site['map'] }
    elsif Vagrant.has_plugin?('vagrant-hostmanager')
        config.hostmanager.enabled = true
        config.hostmanager.manage_host = true
        config.hostmanager.aliases = settings['sites'].map { |site| site['map'] }
    end
end
