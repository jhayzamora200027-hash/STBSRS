<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.
ollama
## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


> composer install
> composer require doctrine/dbal
> composer require laravel/socialite
> composer require smalot/pdfparser --no-interaction
> copy .env.example .env
> npm install chart.js
> npm install jquery
> npm install sweetalert2
> composer require spatie/browsershot
> npm install puppeteer
> npm install bootstrap-icons
> winget install --id Ollama.Ollama --exact --accept-source-agreements --accept-package-agreements
> ollama pull nomic-embed-text

GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret


## INSTALLATION OF OLLAMA
> On Linux: curl -fsSL https://ollama.com/install.sh | sh
> ollama --version

> ollama pull gemma3:4b
> ollama serve

## Local Data Privacy Assistant

The home page includes a chatbot grounded in `public/files/Data Privacy.pdf`.
It uses Ollama locally, so no document or question is sent to a cloud AI provider.

Install Ollama from https://ollama.com/download, then run:

```powershell
ollama pull gemma3:4b
ollama serve
```

Keep `ollama serve` running while using the assistant. The model can be changed with
`OLLAMA_MODEL` in `.env`; after changing environment values, run `php artisan config:clear`.

## Staging Deployment

For an Apache staging server, point the virtual host document root to the
`public` directory, enable HTTPS, and enable the required modules:

```bash
a2enmod headers rewrite
```

Configure the HTTPS virtual host with TLS 1.2 and TLS 1.3 only. The TLS 1.2
cipher list below permits only forward-secret ECDHE AEAD suites; it excludes
CBC and static-RSA key-exchange suites. TLS 1.3 cipher suites are AEAD-only
and are enabled by the TLS 1.3 protocol setting.

```apache
<VirtualHost *:443>
	ServerName staging.example.gov.ph
	DocumentRoot /var/www/istaksyon/STBSRS/public

	SSLEngine on
	SSLCertificateFile /etc/ssl/certs/staging.example.gov.ph/fullchain.pem
	SSLCertificateKeyFile /etc/ssl/private/staging.example.gov.ph.key
	SSLProtocol -all +TLSv1.2 +TLSv1.3
	SSLCipherSuite TLSv1.2 ECDHE-ECDSA-AES128-GCM-SHA256:ECDHE-RSA-AES128-GCM-SHA256:ECDHE-ECDSA-AES256-GCM-SHA384:ECDHE-RSA-AES256-GCM-SHA384:ECDHE-ECDSA-CHACHA20-POLY1305:ECDHE-RSA-CHACHA20-POLY1305
	SSLHonorCipherOrder on

	<Directory "/var/www/istaksyon/STBSRS/public">
		AllowOverride FileInfo Limit
		Require all granted
	</Directory>
</VirtualHost>
```

Replace the certificate paths and hostname with the staging values. Do not
add `TLS_RSA_*` or `*_CBC_*` suites to this configuration. If TLS is
terminated by a load balancer or reverse proxy instead of Apache, apply the
equivalent protocol and cipher policy there and keep the origin connection
encrypted as required by the deployment architecture.

Allow the `public/.htaccess` file to manage headers and URL rewriting:

```apache
<Directory "/var/www/istaksyon/STBSRS/public">
	AllowOverride FileInfo Limit
	Require all granted
</Directory>
```

The staging host must use a valid HTTPS certificate. HSTS is only sent on HTTPS
responses and includes subdomains, so every subdomain of the staging domain
must also support HTTPS.

Set the staging environment values in `.env` without committing the file:

```dotenv
APP_ENV=staging
APP_DEBUG=false
APP_URL=https://staging.example.gov.ph
SESSION_SECURE_COOKIE=true
```

Use the staging database and mail provider credentials, then run the deployment
commands from the project directory:

```bash
composer install --no-dev --optimize-autoloader
php artisan key:generate
php artisan migrate --force
php artisan storage:link
npm ci
npm run build
php artisan config:cache
php artisan view:cache
```

Run Ollama on the staging host or on a private internal host, and configure the
model in `.env`:

```dotenv
OLLAMA_URL=http://127.0.0.1:11434
OLLAMA_MODEL=gemma3:4b
OLLAMA_TIMEOUT=90
```

Install the model and keep Ollama running before testing the assistant:

```bash
ollama pull gemma3:4b
ollama serve
```

The assistant is intended to use a local or private Ollama endpoint. Do not
point `OLLAMA_URL` at a public AI provider when staging privacy-sensitive data.

## IT Execution Checklist

### 1. Web Server

- Set the Apache virtual host document root to `STBSRS/public`.
- Enable the required Apache modules:

```bash
a2enmod ssl headers rewrite
```

- Verify that `public/.htaccess` is present on the server.
- Add the following Apache directory permissions:

```apache
<Directory "/var/www/istaksyon/STBSRS/public">
	AllowOverride FileInfo Limit
	Require all granted
</Directory>
```

- Configure HTTP to redirect to HTTPS.
- Install the TLS certificate and private key.
- Set `SSLProtocol -all +TLSv1.2 +TLSv1.3`.
- Set the TLS 1.2 cipher list to ECDHE AEAD suites only.
- Disable CBC and static-RSA (`TLS_RSA_*`) cipher suites.
- Apply the same TLS settings on the load balancer or reverse proxy if it
  terminates HTTPS.
- Enable HTTPS for all staging subdomains.
- Run `sudo apache2ctl configtest`.
- Run `sudo systemctl reload apache2`.

### 2. Runtime and Permissions

- Install the PHP version and extensions listed in `composer.json`.
- Install Composer and Node.js/npm.
- Configure the staging database, mail service, cache, queue, and filesystem.
- Grant the web-server user write access to `storage/` and `bootstrap/cache/`.
- Keep `.env`, database credentials, OAuth secrets, and mail credentials out of
  version control.

### 3. Application Deployment

Run these commands from the project directory after the source code is deployed:

```bash
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan storage:link
npm ci
npm run build
php artisan config:cache
php artisan view:cache
```

- Set `APP_ENV=staging`, `APP_DEBUG=false`, the HTTPS `APP_URL`, and
	`SESSION_SECURE_COOKIE=true` in `.env`.
- Run `php artisan key:generate` only if the staging environment has no
	application key.

### 4. Local Privacy Assistant

- Run Ollama on the staging server or on a private internal host.
- Do not expose the Ollama port publicly.
- Set `OLLAMA_URL`, `OLLAMA_MODEL`, and `OLLAMA_TIMEOUT` in `.env`.
- Install the configured model and keep the Ollama service running.

```bash
ollama pull gemma3:4b
ollama serve
```

### 5. Verification

- Test the HTTPS endpoint and a static file:

```bash
curl -I https://staging.example.gov.ph/
curl -I https://staging.example.gov.ph/robots.txt
```

- Confirm that both responses contain `Strict-Transport-Security`,
  `X-Content-Type-Options`, `X-Frame-Options`, `Referrer-Policy`,
  `Permissions-Policy`, and `Content-Security-Policy`.
- Test the assistant.
- Confirm that HTTP redirects to HTTPS.
- Run the TLS scan:

```bash
nmap --script ssl-enum-ciphers -p 443 <hostname>
```
