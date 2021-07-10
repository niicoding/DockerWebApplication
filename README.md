# DockerWebApplication
A simple web application consisting of a login-form, a homepage, and a Google reCAPTCHA v2 verification system. The web application is built using Apache2, php, MySQL, and phpMyAdmin. The web application is containerized with Docker, deployed using Docker Compose, and managed in Docker Swarm.

# Google Cloud
## Virtual Machine
1. Visit cloud.google.com and create a Google Cloud account.
2. Go to: Console -> Compute Engine -> VM Instances -> Create Instance.
3. Google may ask that you first create a Project for your VM instance. I named mine "DockerProject".
4. VM instance details:
    Region: us-west2 (Los Angeles)
    Zone: us-west2-a
    Machine configuration:
      Series: E2
      Machine type: e2-small (2vCPUs, 2GB memory)
    Firewalls: 
      Allow HTTP traffic: Yes
      Allow HTTPS traffic: Yes
    Boot disk:
      Operating system: Ubuntu
      Version: Ubuntu 20.04 LTS
      Boot disk type: Balanced persistent disk
      Size: 50 GB
5. Click "Create".
6. Click the three option dots to the right of the instance, and choose "Start / Resume".
      
## Firewall Settings
1. default-allow-http:
    Type: Ingress
    Targets: http-server
    Filters: IP ranges: 0.0.0.0/0
    Protocols / ports: tcp: 80, 8080 (Apache / phpMyAdmin), 1234 (netcat), 3306 (MySQL)
    Action: Allow
2. default-allow-https:
    Type: Ingress
    Targets: https-server
    Filters: IP ranges: 0.0.0.0/0
    Protocols / ports: tcp: 443
    Action: Allow
3. default-allow-icmp:
    Type: Ingress
    Targets: Apply to all
    Filters: IP ranges: 0.0.0.0/0
    Protocols / ports: icmp
    Action: Allow
4. default-allow-internal:
    Type: Ingress
    Targets: Apply to all
    Filters: IP ranges: 10.128.0.0/9
    Protocols / ports: tcp: 0-65535, udp: 0-65535, icmp
    Action: Allow
5. default-allow-rdp
    Type: Ingress
    Targets: Apply to all
    Filters: IP ranges: 0.0.0.0/0
    Protocols / ports: tcp: 3389
    Action: Allow
6. default-allow-ssh
    Type: Ingress
    Targets: Apply to all
    Filters: IP ranges: 0.0.0.0/0
    Protocols / ports: tcp: 22
    Action: Allow
# Docker
The Docker images, project directories, and the docker-compose.yml file are sourced from a macOS tutorial and a GitHub repository written and maintained by Jason McCreary. The Docker components were modified by me to be deployed on an Ubuntu 20.04 LTS operating system hosted on a Google Cloud VM. They were also modified to work alongside a web application consisting of a login form using Google reCaptcha V2 as a verification system.
## Installing Docker
## Installing Docker Compose
## Docker Containers
### php / Apache2
### MySQL
### phpMyAdmin

# Volumes
## workspace
## data
