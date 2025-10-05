# Vagrant box Ubuntu 22.04 LAMP

Make a Vagrant box with Ubuntu 22.04 LAMP stack, plus configure it for development.

- Host: Linux or Mac.
- Guest: Ubuntu 22.04, Apache 2.4, MariaDB 10.6, PHP 8.2, Git 2+.

- Leave code and version control files physically outside the VM while virtually accessing them inside the VM.
- Use any GUI tool (IDEs, browsers, database administration applications, Git clients) outside the VM to access code and data inside the VM.

---

## Details

Read [Stemar Vagrant boxes](https://stemar.github.io/vagrant).

## Summary

VM = virtual machine

### Quick installation

In host machine terminal:

```bash
mkdir -p ~/VM && cd $_
git clone --depth=1 https://github.com/stemar/vagrant-ubuntu-22-04.git ubuntu-22-04
cd ~/VM/ubuntu-22-04
vagrant up --provision
vagrant ssh
```

### Steps

- Prerequisites
- Vagrant preparation
- Virtual machine provisioning
- Configuration checks

### Result

- 64bit Ubuntu 22.04 virtual machine with virtual 64GB HDD, 3GB RAM and updated LAMP stack from [Bento](https://app.vagrantup.com/bento/boxes/ubuntu-22.04).
- Custom `.bash_aliases` to modify bash settings inside the virtual machine.
- Configure LAMP settings from the host machine instead of inside the virtual machine.
- Provisioning in `bash` because the commands can easily be copied/pasted inside a VM or server for troubleshooting.
- Keep multiple Vagrant boxes in a separate location than your projects/code location.
    - `.vagrant/` is created independently within each VM directory.
    - Multiple Vagrant boxes can be run concurrently from separate terminal tabs.
    - Avoid port collision by editing `:forwarded_ports` values in `settings.yaml`.
- Copied SSH keys to use the same in and out of VM.
- Copied Git configurations to use the same in and out of VM.
- Synchronized projects/code directories.
- Apache serves any local website at `http://domain.com.localhost:8000` with [VirtualDocumentRoot](https://httpd.apache.org/docs/2.4/mod/mod_vhost_alias.html).
- Add more VirtualHost blocks from the host machine and re-provision the Vagrant box.
- MariaDB and Adminer with no password for username `root`.
    - Avoid writing a password a zillion times through development.
- Adminer served at `http://localhost:8000/adminer.php`.
- Development-specific `php.ini` settings from `.htaccess` for all local websites.

---

## Prerequisites

- [VirtualBox 6+](https://www.virtualbox.org/wiki/Downloads)
- [VirtualBox 6+ Extension Pack](https://www.virtualbox.org/wiki/Downloads)
- [Vagrant 2+](https://www.vagrantup.com/downloads.html)

SSH keys, Git config settings from host machine are copied in virtual machine.

Check if you have them on your host machine:

```bash
ll ~/.ssh
cat ~/.gitconfig
```

---

## Vagrant preparation

Edit values in `settings.yaml`.

- Edit the `:machine` values if necessary.
- Add arrays to the `:forwarded_ports` value if necessary.
    - Ex.: Change the forwarded ports of this virtual machine to avoid port collision if you have multiple virtual machines running at the same time.
- Change `:synced_folder` values to match your host machine pathname.
- Edit the `:copy_files` values.
- Edit the `:php_error_reporting` value if necessary.

Edit `config` files if needed.

- Edit the `VirtualDocumentRoot` public directory value in `virtualhost.conf`.
- Add `VirtualHost`s in `virtualhost.conf`.
- Edit `php.ini.htaccess` values.
- Add/edit lines to `bash_aliases`.

Edit `provision.sh` if needed.

- Add/edit Linux tools.
- Add/edit PHP libraries.
- Add anything you need.

---

## Virtual machine provisioning

Provision the box from the host machine terminal:

```bash
cd ~/VM/ubuntu-22-04
vagrant up --provision
```

To halt the box:

```bash
vagrant halt -f
```

To boot the box without provisioning:

```bash
vagrant up
```

If anything goes wrong:

```bash
vagrant destroy -f
vagrant box update
vagrant up --provision
```

Check the status of all Vagrant machines on your host machine:

```bash
vagrant global-status
```

Connect to the box through SSH:

```bash
vagrant ssh
```

Bash prompt in virtual machine is now:

```bash
vagrant@ubuntu-22-04:~$
```

---

## Configuration checks

### Check LAMP settings

Check synchronized folders:

```bash
ll ~/Code
ll /vagrant
```

Check versions:

```bash
lsb_release -a
apache2 -v
mysql -V
php -v
python --version
git --version
openssl version
curl --version
```

Check Apache configuration:

```bash
apachectl configtest
apachectl -V
cat /etc/hosts
cat /etc/apache2/apache2.conf
cat /etc/apache2/envvars
ll /etc/apache2/conf-available
ll /etc/apache2/conf-enabled
ll /etc/apache2/sites-available
ll /etc/apache2/sites-enabled
cat /etc/apache2/conf-available/localhost.conf
cat /etc/apache2/sites-available/virtualhost.conf
cat /etc/apache2/conf-available/adminer.conf
sudo cat /var/log/apache2/error.log
```

Check MariaDB databases:

```bash
mysql -u root
MariaDB [(none)]> SHOW DATABASES; quit;
```

Check PHP modules and variables:

```bash
php -m
php -i
```

### Browse local websites

#### Check localhost

<http://localhost:8000>

You see the "Apache2 Ubuntu Default Page".

#### Check Adminer

<http://localhost:8000/adminer.php>

- Username: `root`
- Password: leave empty

#### Check your domain(s)

Replace `domain.com` with your domain and your custom forwarded port number.

<http://domain.com.localhost:8000>

---
