<?php
class Kwf_DeftJS_Assets_JsDependency extends Kwf_Assets_Dependency_File_Js
{
    protected function _getRawContents($language)
    {
        $ret = parent::_getRawContents($language);
        $ret = "(function(Ext) {".$ret."})(this.Ext4);";
        return $ret;
    }
}
