# Inertia.js Demo Application

This is a simple "To Do" application that demonstrates the use of [Inertia.js](https://github.com/inertiajs) to simulate the feel of a single page application from within a standard server side PHP application.  The front-end logic is writtin with Vue.js, the backend with Laravel;  Inertia.js ties them both together, as demonstrated in this example repo.

### Requirements

To run this application you will need to have PHP 7.1.3+ and Node 8+ installed on your system.  You will also need Composer for PHP dependency management and NPM for Node dependency management.  This applicaiton also requires access to a database - any Laravel compatible persistence layer will work.

### Installation

Clone the repo:

```
git clone git@github.com:stagerightlabs/inertiajs-demo.git
cd inertiajs-demo
```

Install the dependencies:

```
composer install
npm ci
```

Create your `.env` file:

```
cp .env.example .env
```

Generate an application key:

```
php artisan key:generate
```

Add your database credentials to your new `.env` file and then run the migrations:

```
php artisan migrate
```

Compile the Javascript assets:

```
npm run build
```

Serve the application:

```
php artisan serve
```

You should now be able to visit `http://localhost:8000` in your browser and see the application in action.
