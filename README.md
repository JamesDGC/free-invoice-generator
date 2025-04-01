# Free Invoice Generator

A free, ATO-compliant invoice generator for Australian businesses. Built with PHP and Tailwind CSS.

## Features

- ATO-compliant invoice generation
- Automatic GST calculation
- PDF export
- No login required
- Mobile responsive design
- Modern UI/UX

## Requirements

- PHP 8.0 or higher
- Composer
- Node.js and npm
- Web server (Apache/Nginx)

## Installation

1. Clone the repository:
```bash
git clone https://github.com/JamesDGC/free-invoice-generator.git
cd free-invoice-generator
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install Node.js dependencies:
```bash
npm install
```

4. Build CSS:
```bash
npm run build
```

5. Configure your web server to point to the `public` directory.

## Deployment on Vultr

1. Create a new Vultr server:
   - Choose Ubuntu 22.04 LTS
   - Select your preferred location (e.g., Sydney)
   - Choose a plan (1GB RAM minimum recommended)
   - Add your SSH key

2. SSH into your server:
```bash
ssh root@your-server-ip
```

3. Install required software:
```bash
# Update system
apt update && apt upgrade -y

# Install Nginx
apt install nginx -y

# Install PHP and extensions
apt install php8.1-fpm php8.1-cli php8.1-mysql php8.1-zip php8.1-gd php8.1-mbstring php8.1-curl php8.1-xml php8.1-bcmath -y

# Install Composer
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

# Install Node.js and npm
curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
apt install -y nodejs
```

4. Configure Nginx:
```bash
cat > /etc/nginx/sites-available/invoice-generator << 'EOL'
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/invoice-generator/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
EOL

ln -s /etc/nginx/sites-available/invoice-generator /etc/nginx/sites-enabled/
rm /etc/nginx/sites-enabled/default
```

5. Deploy the application:
```bash
# Create directory
mkdir -p /var/www/invoice-generator

# Clone repository
git clone https://github.com/yourusername/free-invoice-generator.git /var/www/invoice-generator

# Set permissions
chown -R www-data:www-data /var/www/invoice-generator
chmod -R 755 /var/www/invoice-generator

# Install dependencies
cd /var/www/invoice-generator
composer install --no-dev
npm install
npm run build
```

6. Restart services:
```bash
systemctl restart nginx
systemctl restart php8.1-fpm
```

7. Configure SSL (optional but recommended):
```bash
apt install certbot python3-certbot-nginx -y
certbot --nginx -d your-domain.com
```

## Development

1. Install dependencies:
```bash
composer install
npm install
```

2. Start development server:
```bash
npm run dev
```

3. Build for production:
```bash
npm run build
```

## License

MIT License - feel free to use this project for your own purposes.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request. 