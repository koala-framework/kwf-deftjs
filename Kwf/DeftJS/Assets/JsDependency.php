<?php
class Kwf_DeftJS_Assets_JsDependency extends Kwf_Assets_Dependency_File_Js
{
    private $_fileNameCache;

    public function getAbsoluteFileName()
    {
        if (isset($this->_fileNameCache)) return $this->_fileNameCache;

        $pathType = $this->getType();
        if ($pathType != 'deft') throw new Kwf_Exception("invalid path type: '$pathType'");

        $paths = self::_getAllPaths();
        $f = substr($this->_fileName, strpos($this->_fileName, '/'));
        if (isset($paths[$pathType])) {
            $f = $paths[$pathType]."/packages/deft/src/js/".$f;
        }
        $this->_fileNameCache = $f;
        return $f;
    }

    protected function _getRawContents($language)
    {
        $ret = parent::_getRawContents($language);
        $ret = "(function(Ext) {".$ret."})(this.Ext4);";
        return $ret;
    }
}
