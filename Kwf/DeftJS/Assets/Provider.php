<?php
class Kwf_DeftJS_Assets_Provider extends Kwf_Assets_Provider_Abstract
{
    public function getDependency($dependencyName)
    {
        if (substr($dependencyName, 0, 5) == 'Deft.') {
            $class = $dependencyName;
            $class = substr($class, 5);
            return new Kwf_DeftJS_Assets_JsDependency('deft/'.str_replace('.', '/', $class).'.coffee');
        }
        return null;
    }

    public function getDependenciesForDependency(Kwf_Assets_Dependency_Abstract $dependency)
    {
        if ($dependency instanceof Kwf_DeftJS_Assets_JsDependency && $dependency->getFileNameWithType() == 'deft/mvc/ViewController.js') {
            return array(
                Kwf_Assets_Dependency_Abstract::DEPENDENCY_TYPE_REQUIRES => array(
                    $this->_providerList->findDependency('Deft.mixin.Controllable'),
                ),
            );
        }
        return array();
    }
}
