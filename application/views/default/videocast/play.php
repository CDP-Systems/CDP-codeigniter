    <script type="text/javascript" src="<?php echo $js_dir;?>/swfobject.js"></script>
    <script type="text/javascript">
        var flashvars = {};
        var params = {};
        flashvars.folderPath = "<?php echo site_url('swfplayer');?>/";
        params.scale = "noscale";
        params.salign = "tl";
        params.wmode = "transparent";
        params.allowScriptAccess = "always";
        params.allowFullScreen = "true";
        var attributes = {};
        swfobject.embedSWF(flashvars.folderPath + "VideoPlayerFX.swf", "DivVideoPlayerFX", "600", "360", "9.0.0", false, flashvars, params, attributes);
    </script>

    <div id="DivVideoPlayerFX"></div>
