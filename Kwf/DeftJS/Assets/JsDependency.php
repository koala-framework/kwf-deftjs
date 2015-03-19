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
            $f = $paths[$pathType]."/packages/deft/src/coffee/".$f;
        }
        $this->_fileNameCache = $f;
        return $f;
    }

    protected function _getRawContents($language)
    {
        $ret = parent::_getRawContents($language);
        $coffee = "./vendor/bin/node ".dirname(dirname(dirname(dirname(__FILE__)))).'/node_modules/coffee-script/bin/coffee';

        $inFile = tempnam('temp', 'coffee');
        $outFile = $inFile.'.js';

        file_put_contents($inFile, $ret);
        $cmd = "$coffee -cb $inFile";
        $cmd .= "  2>&1";
        $out = array();
        exec($cmd, $out, $retVal);
        if ($retVal) {
            throw new Kwf_Exception("coffee failed: ".implode("\n", $out));
        }

        if (!file_exists($outFile) && substr($outFile, -7) == '.tmp.js') {
            //under windows files are named .tmp which is stripped by coffee
            $outFile = substr($outFile, 0, -7).'.js'; //
        }

        $ret = file_get_contents($outFile);
        unlink($inFile);
        unlink($outFile);

        $ret = "(function(Ext) {".$ret."})(this.Ext4);";
        return $ret;
    }
}
