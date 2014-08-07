<?php
class Kwf_DeftJS_Assets_JsDependency extends Kwf_Assets_Dependency_File_Js
{
    protected function _getRawContents($language)
    {
        $ret = parent::_getRawContents($language);
        $coffee = dirname(dirname(dirname(dirname(__FILE__)))).'/node_modules/.bin/coffee';

        $inFile = tempnam('temp', 'coffee');
        $outFile = $inFile.'.js';

        file_put_contents($inFile, $ret);
        $cmd = "$coffee -cb $inFile";
        $cmd .= "  2>&1";
        $out = array();
        echo "\n".$cmd."\n";
        exec($cmd, $out, $retVal);
        if ($retVal) {
            throw new Kwf_Exception("coffee failed: ".implode("\n", $out));
        }

        $ret = file_get_contents($outFile);


        $ret = "(function(Ext) {".$ret."})(this.Ext4);";
        return $ret;
    }
}
