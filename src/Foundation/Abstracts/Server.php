<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-08-19 22:47
 */
namespace Notadd\Foundation\Abstracts;
use Illuminate\Bus\BusServiceProvider;
use Illuminate\Cache\CacheServiceProvider;
use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Encryption\Encrypter;
use Illuminate\Filesystem\FilesystemServiceProvider;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Hashing\HashServiceProvider;
use Illuminate\Mail\MailServiceProvider;
use Illuminate\Pagination\PaginationServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationServiceProvider;
use Illuminate\View\ViewServiceProvider;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Notadd\Admin\AdminServiceProvider;
use Notadd\Extension\ExtensionServiceProvider;
use Notadd\Foundation\Application;
use Notadd\Foundation\Auth\AuthServiceProvider;
use Notadd\Foundation\Cookie\CookieServiceProvider;
use Notadd\Foundation\Database\DatabaseServiceProvider;
use Notadd\Foundation\Http\HttpServiceProvider;
use Notadd\Foundation\Localization\LocalizationServiceProvider;
use Notadd\Foundation\Routing\RouterServiceProvider;
use Notadd\Foundation\Session\SessionServiceProvider;
use Notadd\Foundation\Member\Abstracts\Member;
use Notadd\Passport\PassportServiceProvider;
use Notadd\Setting\Contracts\SettingsRepository;
use Notadd\Setting\SettingServiceProvider;
/**
 * Class Server
 * @package Notadd\Foundation\Abstracts
 */
abstract class Server {
    /**
     * @var string
     */
    protected $path;
    /**
     * Server constructor.
     * @param $path
     */
    public function __construct($path) {
        $this->path = $path;
    }
    /**
     * @return \Notadd\Foundation\Application
     */
    protected function getApp() {
        $app = new Application($this->path);
        $app->instance('config', $config = $this->getIlluminateConfig($app));
        $app->instance('encrypter', $this->getEncrypter());
        $app->instance('env', 'production');
        $app->instance('hash', $this->getHashing());
        $this->registerLogger($app);
        $app->register(BusServiceProvider::class);
        $app->register(AuthServiceProvider::class);
        $app->register(CacheServiceProvider::class);
        $app->register(CookieServiceProvider::class);
        $app->register(DatabaseServiceProvider::class);
        $app->register(FilesystemServiceProvider::class);
        $app->register(HashServiceProvider::class);
        $app->register(LocalizationServiceProvider::class);
        $app->register(MailServiceProvider::class);
        $app->register(PaginationServiceProvider::class);
        $app->register(PassportServiceProvider::class);
        $app->register(RouterServiceProvider::class);
        $app->register(SessionServiceProvider::class);
        $app->register(ValidationServiceProvider::class);
        $app->register(ViewServiceProvider::class);
        $app->register(SettingServiceProvider::class);
        if($app->isInstalled()) {
            $setting = $app->make(SettingsRepository::class);
            date_default_timezone_set($setting->get('setting.timezone', 'UTC'));
            $app->setDebugMode($setting->get('setting.debug', true));
            $config->set('mail.driver', $setting->get('mail.driver', 'smtp'));
            $config->set('mail.host', $setting->get('mail.host'));
            $config->set('mail.port', $setting->get('mail.port'));
            $config->set('mail.from.address', $setting->get('mail.from'));
            $config->set('mail.from.name', $setting->get('site.title', 'Notadd'));
            $config->set('mail.encryption', $setting->get('mail.encryption'));
            $config->set('mail.username', $setting->get('mail.username'));
            $config->set('mail.password', $setting->get('mail.password'));
            $app->register(HttpServiceProvider::class);
            $app->register(AdminServiceProvider::class);
            $app->register(ExtensionServiceProvider::class);
        } else {
            $app->setDebugMode(true);
        }
        $app->boot();
        return $app;
    }
    /**
     * @return string
     */
    public function getPath() {
        return $this->path;
    }
    /**
     * @param \Notadd\Foundation\Application $app
     * @return \Illuminate\Config\Repository
     */
    protected function getIlluminateConfig(Application $app) {
        $data = [
            'auth' => [
                'defaults' => [
                    'guard' => 'web',
                    'passwords' => 'users',
                ],
                'guards' => [
                    'web' => [
                        'driver' => 'session',
                        'provider' => 'users',
                    ],
                ],
                'providers' => [
                    'users' => [
                        'driver' => 'eloquent',
                        'model' => Member::class,
                    ],
                ],
            ],
            'cache' => [
                'default' => 'file',
                'stores' => [
                    'file' => [
                        'driver' => 'file',
                        'path' => $app->storagePath() . '/caches',
                    ],
                ],
                'prefix' => 'notadd',
            ],
            'filesystems' => [
                'default' => 'local',
            ],
            'mail' => [
                'driver' => 'mail',
            ],
            'session' => [
                'driver' => 'file',
                'lifetime' => 120,
                'expire_on_close' => false,
                'encrypt' => true,
                'files' => storage_path('sessions'),
                'store' => null,
                'lottery' => [
                    2,
                    100
                ],
                'cookie' => 'notadd_session',
                'path' => '/',
                'domain' => null,
                'secure' => false,
                'http_only' => true,
            ],
            'view' => [
                'paths' => [],
                'compiled' => $app->storagePath() . '/views',
            ],
        ];
        $file = storage_path('notadd') . DIRECTORY_SEPARATOR . 'config.php';
        if(file_exists($file)) {
            $extend = include $file;
            $data = array_merge($data, (array)$extend);
        }
        return new ConfigRepository($data);
    }
    /**
     * @param Application $app
     */
    protected function registerLogger(Application $app) {
        $logger = new Logger($app->environment());
        $logPath = $app->storagePath() . '/logs/notadd.log';
        $handler = new RotatingFileHandler($logPath, 0, Logger::DEBUG);
        $handler->setFormatter(new LineFormatter(null, null, true, true));
        $logger->pushHandler($handler);
        $app->instance('log', $logger);
    }
    /**
     * @param string $path
     */
    public function setPath($path) {
        $this->path = $path;
    }
    /**
     * @return \Illuminate\Encryption\Encrypter
     */
    protected function getEncrypter() {
        $cipher = 'AES-256-CBC';
        $key = 'base64:BlPAX+TJIJqw85JAFiTFOhw6sj9lLiR+l8Qvf6PHlAY=';
        if (Str::startsWith($key, 'base64:')) {
            $key = base64_decode(substr($key, 7));
        }
        return new Encrypter($key, $cipher);
    }
    /**
     * @return \Illuminate\Hashing\BcryptHasher
     */
    protected function getHashing() {
        return new BcryptHasher;
    }
}