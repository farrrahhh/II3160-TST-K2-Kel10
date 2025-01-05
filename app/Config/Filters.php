<?php

namespace Config;

use CodeIgniter\Config\Filters as BaseFilters;
use CodeIgniter\Filters\Cors;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\ForceHTTPS;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\PageCache;
use CodeIgniter\Filters\PerformanceMetrics;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseFilters
{
    /**
     * Configures aliases for Filter classes to make reading things nicer and simpler.
     * @var array<string, class-string|list<class-string>>
     */
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'cors'          => Cors::class,
        'forcehttps'    => ForceHTTPS::class,
        'pagecache'     => PageCache::class,
        'performance'   => PerformanceMetrics::class,
        'jwt'           => \App\Filters\JwtFilter::class, 
        
    ];

    /**
     * List of required filters that provide framework functionality.
     * @var array
     */
    public array $required = [
        'before' => [
            'forcehttps', // Force HTTPS globally
            'pagecache',  // Cache web pages globally
        ],
        'after' => [
            'toolbar',     // Debug Toolbar for development
            'performance', // Performance metrics
        ],
    ];

    /**
     * List of filter aliases that are always applied before and after every request.
     * @var array
     */
    public array $globals = [
        'before' => [
            // Global filters for all requests before executing controllers
        ],
        'after' => [
            // Global filters for all responses after executing controllers
        ],
    ];

    /**
     * List of filter aliases that work on a particular HTTP method.
     * @var array
     */
    public array $methods = [
        
    ];

    /**
     * List of filter aliases that should run on any before or after URI patterns.
     * @var array
     */
    public array $filters = [
        'jwt' => ['before' => ['api/*']], // Apply JWT Filter before handling requests to 'api/*' routes
    ];
}
