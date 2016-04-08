# Anbu Service Agent

To install the anbu service agent:

    composer require daylerees/anbu-agent
    
Install Anbu service profider in your Laravel 5.2.* app:

    Anbu\Profiler\Providers\AnbuServiceProvider::class
    
Install the Anbu global middleware: (`$middleware` in `App\Http\Kernel.php`)

    Anbu\Profiler\Middleware\AnbuMiddleware::class
    
Publish the configuration files:

    php artisan vendor:publish
    
Add your anbu token to `.env`:

    ANBU_TOKEN=this_is_my_anbu_token
    
Ensure that your app has debug mode enabled (for beta):

    APP_DEBUG=true
    
You're done! Enjoy using the anbu beta!
