# DockerWebApplication
A simple web application consisting of a login-form, a homepage, and a Google reCAPTCHA v2 verification system. The web application is built using Apache2, php, MySQL, and phpMyAdmin. The web application is containerized with Docker, deployed using Docker Compose, and managed in Docker Swarm.

# Google Cloud
## Virtual Machine
1. Visit cloud.google.com and create a Google Cloud account.
2. Go to: Console -> Compute Engine -> VM Instances -> Create Instance.
3. Google may ask that you first create a Project for your VM instance. I named mine "DockerProject".
4. VM instance details:\
Region: us-west2 (Los Angeles)\
Zone: us-west2-a\
Machine configuration:\
  Series: E2\
Machine type: e2-small (2vCPUs, 2GB memory)\
Firewalls:\
  Allow HTTP traffic: Yes\
  Allow HTTPS traffic: Yes\
Boot disk:\
  Operating system: Ubuntu\
Version: Ubuntu 20.04 LTS\
Boot disk type: Balanced persistent disk\
  Size: 50 GB
5. Click "Create".
6. Click the three option dots to the right of the instance, and choose "Start / Resume".
      
## Firewall Settings
1. default-allow-http:\
    Type: Ingress\
    Targets: http-server\
    Filters: IP ranges: 0.0.0.0/0\
    Protocols / ports: tcp: 80, 8080 (Apache / phpMyAdmin), 1234 (netcat), 3306 (MySQL)\
    Action: Allow
2. default-allow-https:\
    Type: Ingress\
    Targets: https-server\
    Filters: IP ranges: 0.0.0.0/0\
    Protocols / ports: tcp: 443\
    Action: Allow
3. default-allow-icmp:\
    Type: Ingress\
    Targets: Apply to all\
    Filters: IP ranges: 0.0.0.0/0\
    Protocols / ports: icmp\
    Action: Allow
4. default-allow-internal:\
    Type: Ingress\
    Targets: Apply to all\
    Filters: IP ranges: 10.128.0.0/9\
    Protocols / ports: tcp: 0-65535, udp: 0-65535, icmp\
    Action: Allow
5. default-allow-rdp\
    Type: Ingress\
    Targets: Apply to all\
    Filters: IP ranges: 0.0.0.0/0\
    Protocols / ports: tcp: 3389\
    Action: Allow
6. default-allow-ssh\
    Type: Ingress\
    Targets: Apply to all\
    Filters: IP ranges: 0.0.0.0/0\
    Protocols / ports: tcp: 22\
    Action: Allow
# Docker
The Docker images, project directories, and the docker-compose.yml file are sourced from a macOS tutorial and a GitHub repository written and maintained by Jason McCreary. 
The Docker components were modified by me to be deployed on an Ubuntu 20.04 LTS operating system hosted on a Google Cloud VM. They were also modified to work alongside a 
web application consisting of a login form using Google reCaptcha V2 as a verification system.
## Installing Docker
1. Install using the repository.
  $ sudo apt-get update
  $ sudo apt-get install \\
    apt-transport-https \\
    ca-certificates \\
    curl \\
    gnupg \\
    lsb-release
2. Add the Docker GPG key.\
  $ curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg
3. Set up the stable repository.\
  $ echo \\
    "deb [arch=amd64 signed-by=/usr/share/keyrings/docker-archive-keyring.gpg] https://download.docker.com/linux/ubuntu \
    $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
4. Update the apt package index and install Docker Engine and containerd.\
  $ sudo apt-get update\
  $ sudo apt-get install docker-ce docker-ce-cli containerd.io
5. Confirm that Docker is installed correctly by checking the version.\
  $ docker -v

Source: https://docs.docker.com/engine/install/ubuntu/
## Installing Docker Compose
1. Install the latest release of Docker Compose.
  $ sudo curl -L "https://github.com/docker/compose/releases/download/1.29.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
2. Apply executable permissions to the binary.
  $ sudo chmod +x /usr/local/bin/docker-compose

Source: https://docs.docker.com/compose/install/
## Docker Containers for Web Application
1. Download the .zip file for the contents of this repository.
  $ wget https://github.com/zacharyreeves/DockerWebApplication/archive/refs/heads/main.zip
2. Install the unzip utility.
  $ sudo apt-get install unzip
3. Unzip the repository.
  $ unzip main.zip
4. Clean up by removing the main.zip file.
  $ rm main.zip
5. Rename the directory.
  $ sudo mv DockerWebApplication-main DockerWebApplication
6. Take ownership of the DockerWebApplication directory.
  $ chown -R {user} DockerWebApplication
7. Build the Docker image, make sure you are inside the directory with the images folder.
  $ sudo docker build -t lamp -f images/Dockerfile-php-apache .
8. Run the Docker Container and map port 80 to port 80 of the Docker image we just built.
  $ sudo docker run -d -p 80:80 lamp
9. Verify our web server on the Docker container is running in the background.
  $ sudo docker container ps
10. Visit the external IP address of your Google Cloud VM and verify that there is an Apache error page.
  In a web browser, visit the url http://{external_ip}
11. Stop the container before moving on to the next steps.
  $ sudo docker container stop {docker_image_id}
12. Skip ahead and follow the steps under the Volumes header in this README.md file.
13. Initialize the lamp image, MySQL, and phpMyAdmin in Docker containers using docker-compose
    and the Docker stack will be named 'dev'.
  $ sudo docker swarm init
  $ sudo docker stack deploy -c docker-compose.yml dev
14. We can now stop the stack safely using the below command.
  $ sudo docker stack rm dev.
15. We can restart the server using the same command in step #13.
  $ sudo docker stack deploy -c docker-compose.yml dev.
16. Navigate to myPhpAdmin using the address http://{external_ip}:8080/.
17. Select the drop down menu and select Databases, an error appears: DBUSER has insufficient privilges.
18. Skip ahead to the "MySQL" section.
19. Skip ahead to the "myPhpAdmin" section.
20. Skip ahead to the "Google reCAPTCHA" section.   

### php / Apache2
### MySQL
1. Find the Docker container ID of the MySQL container in our 'dev' stack.
  $ sudo docker container ps
2. Open a /bin/bash shell in the MySQL Docker container.
  $ sudo docker exec -it eefd1976418a /bin/bash
3. Login to MySQL as root.
  $ mysql -u root -p
  $ sup3rs3cr3tp4ssw0rd
4. Click on the phpMyAdmin logo and find the user IP address in the Database server section.
5. Create the 'dbuser' user in the MySQL database.
  $ CREATE USER 'dbuser'@'10.0.2.4' IDENTIFIED BY 'dbpass';
6. Give the 'dbuser' user privileges to preform all operations and flush the privileges.
  $ GRANT ALL PRIVILEGES ON *.* TO 'dbuser'@'10.0.2.4' WITH GRANT OPTION;
  $ FLUSH PRIVILEGES;

Source: http://linuxize.com/post/how-to-create-mysql-user-accounts-and-grant-privileges/
 
### phpMyAdmin
1. Navigate to Databases -> Create database and enter 'phplogin' as the Database name.
2. In the dropdown menu, select utf8_general_ci.
3. Select the database 'phplogin' from the left hand side and select the 'SQL' tab.
4. Enter the following SQL statement:
  CREATE TABLE IF NOT EXISTS 'accounts' (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` varchar(50) NOT NULL,
    `password` varchar(255) NOT NULL,
    `email` varchar(100) NOT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

  INSERT INTO `accounts` (`id`, `username`, `password`, `email`) VALUES (1, 'test', '$2y$10$SfhYIDtn.iOuCW7zfoFLuuZHX6lja4lF4XA4JqNmpiH/.P3zB8JCa', 'test@test.com');

# Google reCAPTCHA
1. Visit https://www.google.com/recaptcha/admin/create
2. Create a label for your reCAPTCHA button
3. Select reCAPTCHA v2 button -> "'I'm not a robot' Checkbox"
4. Add the external IP address of your VM to the "Domains" section.
5. Accept the Terms of Service, and then click the "Submit" button.
6. Go to "Settings" and take note of the "reCAPTCHA keys."
7. Edit /home/{user}/workspace/html/captcha.html and paste the "Site Key"
   into the "data-sitekey" field.
8. Edit /home/{user}/workspace/html/verify_captcha.html and paste the "Secret Key"
   into the "secret" field.

# Volumes
## workspace
1. The workspace directory is included in the repository, place it in home.
  $ sudo mv workspace /home/{user}/workspace
2. Take ownership of the workspace directory.
  $ chown -R {user} /home/{user}/workspace
3. Set up the volume for the workspace directory.
  $ docker volume create workspace --opt type=none --opt device=/home/{user}/workspace --opt o=bind
## data
1. Create the workspace directory.
  $ mkdir ~/data
2. Take ownership of the data directory.
  $ chown -R {user} /home/{user}/data
3. Set up the volume for the data directory.
  $ docker volume create data --opt type=none --opt device=/home/{user}/data --opt o=bind
