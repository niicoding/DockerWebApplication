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

# Docker
## Docker Containers
### php / Apache2
### MySQL
### phpMyAdmin

# Volumes
## workspace
## data
