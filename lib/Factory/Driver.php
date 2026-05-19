<?php
use Horde\Injector\Injector;

/**
 * Tessera_Driver factory.
 *
 * @author    Dmitry Petrov <dpetrov67@gmail.com>
 * @package   Tessera
 */
class Tessera_Factory_Driver extends Horde_Core_Factory_Injector
{
    /**
     * @var array
     */
    private $_instances = [];

    /**
     * Return an Tessera_Driver instance.
     *
     * @return Tessera_Driver
     */
    public function create(Horde_Injector|Injector $injector)
    {
        global $conf;

        $driver = Horde_String::ucfirst($conf['storage']['driver']);
        $signature = serialize([ $driver, $conf['storage']['params']['driverconfig'] ]);
        if (empty($this->_instances[$signature])) {
            switch ($driver) {
                case 'Sql':
                    try {
                        if ($conf['storage']['params']['driverconfig'] == 'horde') {
                            $db = $injector->getInstance('Horde_Db_Adapter');
                        } else {
                            $db = $injector->getInstance('Horde_Core_Factory_Db')->create('tessera', 'storage');
                        }
                    } catch (Horde_Exception $e) {
                        throw new Tessera_Exception($e);
                    }
                    $params = [ 'db' => $db ];
                    break;
                case 'Ldap':
                    try {
                        $params = [ 'ldap' => $injector->getIntance('Horde_Core_Factory_Ldap')->create('tessera', 'storage') ];
                    } catch (Horde_Exception $e) {
                        throw new Tessera_Exception($e);
                    }
                    break;
            }
            $class = 'Tessera_Driver_' . $driver;
            $this->_instances[$signature] = new $class($params);
        }

        return $this->_instances[$signature];
    }
}
