<?php
/**
 * FileCache Class
 *
 * @author      Mariusz 'Fu-Hsi' Kacki
 * @copyright   2015 Mariusz 'Fu-Hsi' Kacki
 * @package     FileCache
 * @version     1.0.0
 * @link        https://github.com/fu-hsi/file-cache
 * @license     http://opensource.org/licenses/MIT MIT License
 */
namespace FuHsi;

/**
 *
 * @package FileCache
 * @author Mariusz 'Fu-Hsi' Kacki
 * @since 1.0.0
 */
class FileCache
{

    const MINUTE = 60;

    const HOUR = 3600;

    const DAY = 86400;

    const WEEK = 604800;

    const MONTH = 2592000;

    const YEAR = 31104000;

    /**
     *
     * @var array
     */
    private $options = array();

    /**
     *
     * @param array $options            
     */
    public function __construct(array $options = array())
    {
        $this->options = array_merge(array(
            'cacheDir' => '.',
            'lifeTime' => self::HOUR
        ), $options);
    }

    /**
     *
     * @param string $key            
     * @return string
     */
    private function getFileName($key)
    {
        $fileName = rtrim($this->options['cacheDir'], '/\\') . DIRECTORY_SEPARATOR . md5($key) . '.php';
        return $fileName;
    }

    /**
     *
     * @param string $key            
     * @param bool $extendLife            
     * @param callable $dataSourceCallback            
     * @return mixed|NULL
     */
    public function get($key, $extendLife = false, callable $dataSourceCallback = null)
    {
        $fileName = $this->getFileName($key);
        
        if (file_exists($fileName) && filesize($fileName) && time() - filemtime($fileName) <= $this->options['lifeTime']) {
            if ($extendLife) {
                touch($fileName);
            }
            return include ($fileName);
        }
        
        if ($dataSourceCallback) {
            $data = $dataSourceCallback();
            if ($this->set($key, $data)) {
                return $data;
            }
        }
        
        return null;
    }

    /**
     *
     * @param string $key            
     * @param mixed $data The variable you want to store
     * @return int|bool Returns the number of bytes that were written to the file, or false on failure
     */
    public function set($key, &$data)
    {
        $fileName = $this->getFileName($key);
        return file_put_contents($fileName, '<?php return ' . var_export($data, true) . '; ?>');
    }
}

?>